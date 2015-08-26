<?php

namespace Barra\RestBundle\Controller;

use Barra\BackBundle\Form\Type\RecipeType;
use Barra\FrontBundle\Entity\Recipe;
use Barra\FrontBundle\Entity\Repository\RecipeRepository;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Annotations;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RecipeController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class RecipeController extends FOSRestController
{
    /** @var EntityManager  */
    protected $em;


    /**
     * Returns form
     * @return \Symfony\Component\Form\Form
     */
    public function newRecipeAction() {
        $form = $this->createForm(new RecipeType(), new Recipe());

        return ['data' => $form];
    }


    /**
     * List all entries
     * @Annotations\View()
     * @Annotations\QueryParam(name="offset",   requirements="\d+", default="0",   description="Offset to start from.")
     * @Annotations\QueryParam(name="limit",    requirements="\d+", default="2",   description="How many entries to return.")
     * @Annotations\QueryParam(name="order_by", requirements="\w+", default="id",  description="Column to order by.")
     * @Annotations\QueryParam(name="order",    requirements="\w+", default="ASC", description="Order, either ASC or DESC.")
     * @param ParamFetcher $paramFetcher
     * @return array
     */
    public function getRecipesAction(ParamFetcher $paramFetcher)
    {
        $offset     = (int) $paramFetcher->get('offset');
        $limit      = (int) $paramFetcher->get('limit');
        $orderBy    = $paramFetcher->get('order_by');
        $order      = $paramFetcher->get('order');

        /** @var RecipeRepository $repo */
        $repo       = $this->getRepo();
        $entities   = $repo->getSome($offset, $limit, $orderBy, $order);

        return ['data' => $entities];
    }


    /**
     * Get single entry
     * @Annotations\View()
     * @param int $id
     * @return array
     */
    public function getRecipeAction($id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Recipe) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return ['data' => $entity];
    }


    /**
     * Create new entry
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function postRecipeAction(Request $request)
    {
        return $this->processForm($request, new Recipe(), Codes::HTTP_CREATED);
    }


    /**
     * Replace or create entry
     * @param Request   $request
     * @param int       $id
     * @return array|\FOS\RestBundle\View\View
     */
    public function putRecipeAction(Request $request, $id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Recipe) {
            return $this->routeRedirectView('barra_api_post_recipe', ['request' => $request]);
        }

        return $this->processForm($request, $entity, Codes::HTTP_NO_CONTENT);
    }


    /**
     * Actual form handling
     * @param Request   $request
     * @param Recipe    $entity
     * @param int       $successCode
     * @return \FOS\RestBundle\View\View
     */
    protected function processForm(Request $request, Recipe $entity, $successCode)
    {
        $form = $this->createForm(new RecipeType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        $duplicate = $this->getRepo()->findOneByName($entity->getName());
        if ($duplicate instanceof Recipe) {
            return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->getEM()->persist($entity);
        $this->getEM()->flush();

        $params = [
            'id'        => $entity->getId(),
            '_format'   => $request->get('_format'),
        ];

        return $this->routeRedirectView('barra_api_get_recipe', $params, $successCode);
    }


    /**
     * Delete one recipe
     * @Annotations\View()
     * @param int   $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteRecipeAction($id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Recipe) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        // TODO onDelete=Cascade instead of manually calling RecipePicture.removeUpload()
        foreach ($entity->getPhotos() as $image) {
            $this->getEM()->remove($image);
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
    protected function getRepo($className = 'Recipe') {
        return $this->getEM()->getRepository('BarraFrontBundle:'.$className);
    }
}