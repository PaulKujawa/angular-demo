<?php

namespace Barra\RestBundle\Controller;

use Barra\FrontBundle\Entity\Recipe;
use Symfony\Component\HttpFoundation\Request;
use Barra\BackBundle\Form\Type\RecipeType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Util\Codes;

class RecipeController extends FOSRestController
{
    /**
     * @View(statusCode=200, templateVar="recipe")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getRecipeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository("BarraFrontBundle:Recipe")->find($id);
        if (!is_object($recipe))
            throw $this->createNotFoundException();
        return $recipe;
    }



    /**
     * @View(statusCode=200, templateVar="recipes")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getRecipesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository("BarraFrontBundle:Recipe")->findAll();
        return $recipes;
    }



    /**
     * @View()
     * @param Request $request
     * @return \FOS\RestBundle\View\View|\Symfony\Component\Form\Form
     */
    public function postRecipeAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->createForm(new RecipeType(), $recipe);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $recipe->setRating(50)->setVotes(2);
            $recipeName = $request->getName();
            $em->persist($recipe);
            $em->flush();
            return $this->routeRedirectView('barra_api_get_recipe', array('name' => $recipeName), Codes::HTTP_CREATED); // incl. location header
        }
        return $form; // 400 Bad Request + validation errors
    }



    /**
     * @View()
     * @param Request $request
     * @param $id
     * @return \FOS\RestBundle\View\View|\Symfony\Component\Form\Form
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function putRecipeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($id);
        if (!is_object($recipe))
            throw $this->createNotFoundException();

        $form = $this->createForm(new RecipeType(), $recipe, array('method'=>'PUT'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();
            return $this->view(null, Codes::HTTP_NO_CONTENT);
        }
        return $form;
    }


    /**
     * @View()
     * @param $id
     * @return \FOS\RestBundle\View\View
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteRecipeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($id);
        if (!is_object($recipe))
            throw $this->createNotFoundException();

        foreach($recipe->getRecipePictures() as $image) // TODO should be carried via onDelete=Cascade, but isn't
            $em->remove($image); // manually called deletions to trigger the removeUpload() as well
        $em->remove($recipe);
        $em->flush();
        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }
}