<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\CookingStep;
use Barra\FrontBundle\Entity\RecipeIngredient;
use Barra\BackBundle\Form\Type\RecipeIngredientType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    public function indexAction(Request $request)
    {
        // Form
        $recipeIngredient = new RecipeIngredient();
        $form = $this->createForm(new RecipeIngredientType(), $recipeIngredient);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $recipe = $recipeIngredient->getRecipe()->setRating(50)->setVotes(2);
            $sqlError = $this->newRecipeAction($recipe);

            if ($sqlError)
                return new Response($sqlError);

            $recipeIngredient->setRecipe($recipe);
            $recipeIngredient->setPosition(1);
            $sqlError = $this->newRecipeIngredientAction($recipeIngredient);

            if ($sqlError)
                return new Response($sqlError);

            $cookingStep = $recipeIngredient->
            $cookingStep->setRecipe($recipe)->setStep(1);
            $cookingStep->newCookingStepAction($recipe);

            return $this->redirect($this->generateUrl('barra_back_recipes'));

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


    public function updateRecipeIngredient($id, $recipe, $ingredient, $position, $measurement, $amount)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeIngredient = $em->getepository('BarraFrontBundle:RecipeIngredient')->find($id);
        $recipeIngredient->setRecipe($recipe)->setIngredient($ingredient)->setPosition($position)
            ->setMeasurement($measurement)->setAmount($amount);
        $em->flush();
        return new Response('Success! Updated relation');
    }


    public function deleteRecipeIngredientAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeIngredient = $em->getRepository('BarraFrontBundle:RecipeIngredient')->find($id);

        if (!$recipeIngredient)
            throw $this->createNotFoundException('Relation with id '.$id.' not found');

        $em->remove($recipeIngredient);
        $em->flush();
        return new Response('Success! Deleted relation with id '.$id);
    }







    public function newCookingStepAction($cookingStep)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($cookingStep);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Cooking step could not be inserted');
        }
        return null;
    }


    public function updateCookingStep($recipe, $step, $description)
    {
        $em = $this->getDoctrine()->getManager();
        $cooking = $em->getRepository('BarraFrontBundle:CookingStep')->findOneBy(array(
                'recipe'=>$recipe, 'step'=>$step)
        );
        $cooking->setRecipe($recipe)->setStep($step)->setDescription($description);
        $em->flush();
        return new Response('Success! Updated cooking step');
    }


    public function deleteCookingStepAction($recipe, $step)
    {
        $em = $this->getDoctrine()->getManager();
        $cooking = $em->getRepository('BarraFrontBundle:CookingStep')->findOneBy(array(
                'recipe'=>$recipe, 'step'=>$step)
        );

        if (!$cooking)
            throw $this->createNotFoundException('Cooking step not found');

        $em->remove($cooking);
        $em->flush();
        return new Response('Success! Deleted cooking step');
    }
}
