<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Recipe;
use Barra\FrontBundle\Entity\RecipeIngredient;
use Barra\BackBundle\Form\Type\RecipeIngredientType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{

    // TODO simple view action
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($id);

        $recipeIngredient = new RecipeIngredient();
        $form = $this->createForm(new RecipeIngredientType(), $recipeIngredient);


        return $this->render('BarraBackBundle:Recipe:recipe.html.twig', array(
            'recipe' => $recipe,
            'formIngredients' => $form->createView()
        ));
    }

    // TODO choose different (form) actions depending on request & POST
    public function formIngredientAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($id);

        // Form
        $recipeIngredient = new RecipeIngredient();
        $form = $this->createForm(new RecipeIngredientType(), $recipeIngredient);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $recipeIngredient->setRecipe($recipe);
            $recipeIngredient->setPosition(1);
            $sqlError = $this->newRecipeIngredientAction($recipeIngredient);

            if ($request->request->has(''))


            if ($sqlError)
                return new Response($sqlError);

            /*

             $cookingStep = $recipeIngredient->
                $cookingStep->setRecipe($recipe)->setStep(1);
            $cookingStep->newCookingStepAction($recipe);*/

            $id = $recipe->getId();
            return $this->redirect($this->generateUrl('barra_back_recipe', array('id' => $id)));

        }

        // Overview
        return $this->render('BarraBackBundle:Recipe:recipe.html.twig', array(
            'recipe' => $recipe,
            'formIngredients' => $form->createView()
        ));
    }




    public function newRecipeIngredientAction($recipeIngredient)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($recipeIngredient);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Recipe relation could not be inserted');
        }
        return null;
    }

}
