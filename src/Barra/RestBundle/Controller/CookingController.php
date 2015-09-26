<?php

namespace Barra\RestBundle\Controller;

use Barra\BackBundle\Form\Type\CookingType;
use Barra\BackBundle\Entity\Cooking;
use Barra\BackBundle\Entity\Recipe;
use Barra\BackBundle\Entity\Repository\CookingRepository;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Annotations;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CookingController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class CookingController extends FOSRestController
{
    /** @var EntityManager  */
    protected $em;


    /**
     * Returns form
     * @return \Symfony\Component\Form\Form
     */
    public function newCookingAction()
    {
        $form = $this->createForm(new CookingType(), new Cooking());

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
    public function getCookingsAction(ParamFetcher $paramFetcher)
    {
        $recipe     = (int) $paramFetcher->get('recipe');
        $offset     = (int) $paramFetcher->get('offset');
        $limit      = (int) $paramFetcher->get('limit');
        $orderBy    = $paramFetcher->get('order_by');
        $order      = $paramFetcher->get('order');

        /** @var CookingRepository $repo */
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
    public function getCookingAction($id)
    {
        $entity = $this->getRepo()->find($id);

        if (!$entity instanceof Cooking) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return ['data' => $entity];
    }


    /**
     * Create new entry
     * @param Request   $request
     * @return \FOS\RestBundle\View\View
     */
    public function postCookingAction(Request $request)
    {
        return $this->processForm($request, new Cooking(), Codes::HTTP_CREATED);
    }


    /**
     * Replace or create entry
     * @param Request   $request
     * @param int       $id
     * @return \FOS\RestBundle\View\View
     */
    public function putCookingAction(Request $request, $id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Cooking) {
            return $this->routeRedirectView('barra_api_post_cooking', ['request' => $request]);
        }

        return $this->processForm($request, $entity, Codes::HTTP_NO_CONTENT);
    }


    /**
     * Actual form handling
     * @param Request   $request
     * @param Cooking   $entity
     * @param int       $successCode
     * @return \FOS\RestBundle\View\View
     */
    protected function processForm(Request $request, Cooking $entity, $successCode)
    {
        $requestBody = array_values($request->request->all())[0];
        $recipe      = $this->getRepo('Recipe')->find($requestBody['recipe']);
        $form        = $this->createForm(new CookingType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid() ||
            !$recipe instanceof Recipe
        ) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        if ($request->isMethod('POST')) {
            $position = $this->getRepo()->getNextPosition($recipe->getId());
            $entity
                ->setPosition($position)
                ->setRecipe($recipe)
            ;
        };

        $duplicate = $this->getRepo()->find($entity->getId());
        if ($duplicate instanceof Cooking) {
            return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->getEM()->persist($entity);
        $this->getEM()->flush();

        $params = [
            'id'        => $entity->getId(),
            '_format'   => $request->get('_format'),
        ];

        return $this->routeRedirectView('barra_api_get_cooking', $params, $successCode);
    }


    /**
     * Delete one cooking
     * @Annotations\View()
     * @param int   $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteCookingAction($id)
    {
        $entity = $this->getRepo()->find($id);

        if (!$entity instanceof Cooking) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        if (!$entity->isRemovable()) {
            return $this->view(null, Codes::HTTP_CONFLICT);
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
    protected function getRepo($className = 'Cooking')
    {
        return $this->getEM()->getRepository('BarraBackBundle:'.$className);
    }
}
