<?php

namespace Barra\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Annotations;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;

use Barra\BackBundle\Form\Type\RecipeType;
use Barra\FrontBundle\Entity\Recipe;


/**
 * Class RecipeController
 * @package Barra\RestBundle\Controller
 */
class RecipeController extends FOSRestController
{
    /**
     * Presents the form to use to create a new recipe.
     * @return \Symfony\Component\Form\Form
     */
    public function newRecipeAction() {
        return $this->createForm(new RecipeType());
    }


    /**
     * List all recipes
     * @Annotations\View()
     * @return array
     */
    public function getRecipesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("BarraFrontBundle:Recipe")->findAll();
        return array("recipes" => $entities);
    }


    /**
     * List some recipes
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing recipes.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="2", description="How many recipes to return.")
     * @Annotations\View()
     * @param ParamFetcher $paramFetcher
     * @return mixed
     */
    public function getRecipesLimitedAction(ParamFetcher $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        if (is_null($offset)) $offset = 0;

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BarraFrontBundle:Recipe')->getSome($offset, $limit);
        return array("recipes" => $entities);
    }


    /**
     * Get single recipe
     * @Annotations\View()
     * @param int $id
     * @return array
     */
    public function getRecipeAction($id)
    {
        $entity = $this->getEntity($id);
        return array("recipe" => $entity);
    }


    /**
     * Create a recipe from the submitted data
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function postRecipeAction(Request $request)
    {
        $recipe = new Recipe();
        $recipe->setRating(50)->setVotes(2);
        return $this->processForm($request, $recipe, "POST", Codes::HTTP_CREATED);
    }


    /**
     * Replace an existing recipe from the submitted data at a specific location or create a new recipe
     * @param Request   $request
     * @param int       $id
     * @return array|\FOS\RestBundle\View\View
     */
    public function putRecipeAction(Request $request, $id)
    {
        try {
            $entity = $this->getEntity($id);
            return $this->processForm($request, $entity, "PUT", Codes::HTTP_NO_CONTENT);
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return $this->routeRedirectView('barra_api_post_recipe', array("request"=>$request));
        }
    }


    /**
     * Delete one recipe
     * @Annotations\View()
     * @param int   $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteRecipeAction($id)
    {
        $entity = $this->getEntity($id);
        $em = $this->getDoctrine()->getManager();

        // TODO onDelete=Cascade instead of manually calling RecipePicture.removeUpload()
        foreach($entity->getRecipePictures() as $image)
            $em->remove($image);

        $em->remove($entity);
        $em->flush();
        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }


    /**
     * @param Request $request
     * @param Recipe $entity
     * @param $method
     * @param $successCode
     * @return \FOS\RestBundle\View\View
     */
    protected function processForm(Request $request, Recipe $entity, $method, $successCode)
    {
        $form = $this->createForm(new RecipeType(), $entity, array('method'=>$method));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            try {
                $em->flush();
            } catch (\Doctrine\DBAL\DBALException $e) {
                return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
            }

            $params = array('id' => $entity->getId(), '_format'=>$request->get("_format"));
            return $this->routeRedirectView('barra_api_get_recipe', $params, $successCode);
        }
        return $this->view($form, Codes::HTTP_BAD_REQUEST);

    }


    /**
     * Get a recipe from the repository
     * @param int   $id
     * @return object
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function getEntity($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("BarraFrontBundle:Recipe")->find($id);
        if (!$entity instanceof Recipe)
            throw $this->createNotFoundException();
        return $entity;
    }
}