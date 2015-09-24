<?php

namespace Barra\RestBundle\Controller;

use Barra\BackBundle\Form\Type\PhotoType;
use Barra\BackBundle\Entity\Recipe;
use Barra\BackBundle\Entity\Photo;
use Barra\BackBundle\Entity\Repository\PhotoRepository;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Annotations;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PhotoController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class PhotoController extends FOSRestController
{
    /** @var EntityManager  */
    protected $em;


    /**
     * Returns form
     * @return \Symfony\Component\Form\Form
     */
    public function newPhotoAction()
    {
        $form = $this->createForm(new PhotoType(), new Photo());

        return ['data' => $form];
    }


    /**
     * List all entries
     * @Annotations\View()
     * @Annotations\QueryParam(
     *      name            = "recipe",
     *      requirements    = "\d+",
     *      description     = "Recipe to get entries from."
     * )
     * @Annotations\QueryParam(
     *      name            = "offset",
     *      requirements    = "\d+",
     *      default         = "0",
     *      description     = "Offset to start from."
     * )
     * @Annotations\QueryParam(
     *      name            = "limit",
     *      requirements    = "\d+",
     *      default         = "4",
     *      description     = "How many entries to return."
     * )
     * @Annotations\QueryParam(
     *      name            = "order_by",
     *      requirements    = "\w+",
     *      default         = "id",
     *      description     = "Column to order by."
     * )
     * @Annotations\QueryParam(
     *      name            = "order",
     *      requirements    = "\w+",
     *      default         = "ASC",
     *      description     = "Order, either ASC or DESC."
     * )
     * @param ParamFetcher $paramFetcher
     * @return array
     */
    public function getPhotosAction(ParamFetcher $paramFetcher)
    {
        $recipe     = (int) $paramFetcher->get('recipe');
        $offset     = (int) $paramFetcher->get('offset');
        $limit      = (int) $paramFetcher->get('limit');
        $orderBy    = $paramFetcher->get('order_by');
        $order      = $paramFetcher->get('order');

        /** @var PhotoRepository $repo */
        $repo       = $this->getRepo();
        $entities   = $repo->getSome($recipe, $offset, $limit, $orderBy, $order);

        return ['data' => $entities];
    }


    /**
     * Get single entry
     * @Annotations\View()
     * @param int $id
     * @return array
     */
    public function getPhotoAction($id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Photo) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }


        return ['data' => $entity];
    }


    /**
     * Create new entry
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function postPhotoAction(Request $request)
    {
        return $this->processForm($request, new Photo(), Codes::HTTP_CREATED);
    }


    /**
     * Replace or create entry
     * @param Request   $request
     * @param int       $id
     * @return array|\FOS\RestBundle\View\View
     */
    public function putPhotoAction(Request $request, $id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Photo) {
            return $this->routeRedirectView('barra_api_post_Photo', ['request' => $request]);
        }

        return $this->processForm($request, $entity, Codes::HTTP_NO_CONTENT);
    }


    /**
     * Actual form handling
     * @param Request   $request
     * @param Photo     $entity
     * @param int       $successCode
     * @return \FOS\RestBundle\View\View
     */
    protected function processForm(Request $request, Photo $entity, $successCode)
    {
        $requestBody = array_values($request->request->all())[0];
        $recipe      = $this->getRepo('Recipe')->find($requestBody['recipe']);
        $form        = $this->createForm(new PhotoType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid() ||
            !$recipe instanceof Recipe
        ) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        // TODO check dat
        /** @var UploadedFile $file */
        $file = $request->files[0];

        if ($request->isMethod('POST')) {
            $entity
                ->setRecipe($recipe)
                ->setFile($file)
                ->setSize($file->getClientSize())
            ;
        }

        $duplicate = $this->getRepo()->findOneByName($entity->getName());
        if ($duplicate instanceof Photo) {
            return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->getEM()->persist($entity);
        $this->getEM()->flush();

        $params = [
            'id'        => $entity->getId(),
            '_format'   => $request->get('_format'),
        ];

        return $this->routeRedirectView('barra_api_get_Photo', $params, $successCode);
    }


    /**
     * Delete one Photo
     * @Annotations\View()
     * @param int   $id
     * @return \FOS\RestBundle\View\View
     */
    public function deletePhotoAction($id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Photo) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        $this->getEM()->remove($entity);
        $this->getEM()->flush();

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }


    /**
     * @return EntityManager
     */
    protected function getEM()
    {
        if (is_null($this->em)) {
            $this->em = $this->getDoctrine()->getManager();
        }

        return $this->em;
    }


    /**
     * @param string $className
     * @return \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    protected function getRepo($className = 'Photo')
    {
        return $this->getEM()->getRepository('BarraBackBundle:'.$className);
    }
}
