<?php

namespace Barra\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
     * Get recipes with optional offset and limited entries (default=2)
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
     * Get one recipe
     * @Annotations\View()
     * @param $id
     * @return array
     */
    public function getRecipeAction($id)
    {
        $entity = $this->getEntity($id);
        return array("recipe" => $entity);
    }


    /**
     * Get all recipes
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
     * Post one new recipe through the form
     * @param Request $request
     * @return \FOS\RestBundle\View\View|Response
     */
    public function postRecipeAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->createForm(new RecipeType(), $recipe);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $recipe->setRating(50)->setVotes(2);
            $em->persist($recipe);

            try {
                $em->flush();
            } catch (\Doctrine\DBAL\DBALException $e) {
                return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
            }
            return $this->redirectView($this->generateUrl('barra_api_get_recipe', array('id' => $recipe->getId())), Codes::HTTP_CREATED);
        }
        return $this->view($form, Codes::HTTP_BAD_REQUEST);
    }


    /**
     * Update one recipe
     * @param Request $request
     * @param $id
     * @return array|\FOS\RestBundle\View\View
     */
    public function putRecipeAction(Request $request, $id)
    {
        $entity = $this->getEntity($id);
        $form = $this->createForm(new RecipeType(), $entity, array('method'=>'PUT'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->view(null, Codes::HTTP_NO_CONTENT);
        }
        return $this->view($form, Codes::HTTP_BAD_REQUEST);
    }


    /**
     * Delete one recipe
     * @Annotations\View(statusCode=204)
     * @param $id
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
    }


    /**
     * Get a recipe from the repository
     * @param $id
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