<?php

namespace Barra\RestBundle\Controller;

use Barra\BackBundle\Form\Type\RecipeType;
use Barra\FrontBundle\Entity\Recipe;
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
     * Presents the form to use to create a new recipe.
     * @return \Symfony\Component\Form\Form
     */
    public function newRecipeAction() {
        $form = $this->createForm(new RecipeType(), new Recipe());

        return array('data' => $form);
    }


    /**
     * List all entries
     * @Annotations\View()
     * @Annotations\QueryParam(name="offset",   requirements="\d+", nullable=true, description="Offset to start from.")
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
        if (is_null($offset)) $offset = 0;
        $entities = $this->getRepo('Recipe')->getSome($offset, $limit, $orderBy, $order);

        return array('data' => $entities);
    }


    /**
     * Get single entry
     * @Annotations\View()
     * @param int $id
     * @return array
     */
    public function getRecipeAction($id)
    {
        $entity = $this->getRepo('Recipe')->find($id);
        if (is_null($entity)) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return array('data' => $entity);
    }


    /**
     * Create new entry
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function postRecipeAction(Request $request)
    {
        $recipe = new Recipe();
        $recipe
            ->setRating(50)
            ->setVotes(2)
        ;
        return $this->processForm($request, $recipe, 'POST', Codes::HTTP_CREATED);
    }


    /**
     * Replace or create entry
     * @param Request   $request
     * @param int       $id
     * @return array|\FOS\RestBundle\View\View
     */
    public function putRecipeAction(Request $request, $id)
    {
        /** @var Recipe $entity */
        $entity = $this->getRepo('Recipe')->find($id);
        if (is_null($entity)) {
            return $this->routeRedirectView('barra_api_post_recipe', array('request'=>$request));
        }

        return $this->processForm($request, $entity, 'PUT', Codes::HTTP_NO_CONTENT);
    }


    /**
     * Delete one recipe
     * @Annotations\View()
     * @param int   $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteRecipeAction($id)
    {
        $entity = $this->getRepo('Recipe')->find($id);

        if (is_null($entity)) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        // TODO onDelete=Cascade instead of manually calling RecipePicture.removeUpload()
        foreach ($entity->getRecipePictures() as $image) {
            $this->getEM()->remove($image);
        }

        $this->getEM()->remove($entity);
        $this->getEM()->flush();

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }


    /**
     * Actual form handling
     * @param Request $request
     * @param Recipe    $entity
     * @param string    $method
     * @param int       $successCode
     * @return \FOS\RestBundle\View\View
     */
    protected function processForm(Request $request, Recipe $entity, $method, $successCode)
    {
        $form = $this->createForm(new RecipeType(), $entity, array('method' => $method));
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        $this->getEM()->persist($entity);
        $this->getEM()->flush();

        $params = array(
            'id'        => $entity->getId(),
            '_format'   => $request->get('_format'),
        );

        return $this->routeRedirectView('barra_api_get_recipe', $params, $successCode);
    }


    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|EntityManager|object
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
    protected function getRepo($className) {
        return $this->getEM()->getRepository('BarraFrontBundle:'.$className);
    }
}