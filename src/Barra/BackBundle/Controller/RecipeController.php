<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Recipe;
use Barra\BackBundle\Form\Type\RecipeType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    public function indexAction()
    {
        // Form
        $recipe = new Recipe();
        $form = $this->createForm(new RecipeType(), $recipe);

        $form->handleRequest($recipe);

        if ($form->isValid()) {
            $recipe->setRating(50)->setVotes(2);
            $sqlError = $this->newRecipeAction($recipe);

            if ($sqlError)
                return new Response($sqlError);
            else {
        //        $recipeIngredient = new RecipeIngredientController();
          //      $recipeIngredient->newRecipeIngredientAction($recipe, $ingredient, 1, $measurement, $amount);

                // $cookingStep = new CookingStepController();
                // $cookingStep->newCookingStepAction($recipe, 1, $firstCookingStep);

                return $this->redirect($this->generateUrl('barra_back_ingredients'));
            }


        }

        // Overview
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('BarraFrontBundle:Recipe')->findAll();

        return $this->render('BarraBackBundle:Recipe:recipes.html.twig', array(
                'recipes' => $recipes,
                'form' => $form->createView()
            ));
    }


    public function newRecipeAction($recipe)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Recipe could not be inserted');
        }
        return null;
    }


    public function updateRecipe($id, $name, $ingredient, $measurement, $amount, $firstCookingStep)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($id);
        $recipe->setName($name)->setRating(50)->setVotes(2);
        $em->flush();
        return new Response('Success! Updated recipe');
    }


    public function deleteRecipeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($id);

        if (!$recipe)
            throw $this->createNotFoundException('Recipe with id '.$id.' not found');

        $em->remove($recipe);
        $em->flush();
        return new Response('Success! Deleted recipe with id '.$id);
    }
}