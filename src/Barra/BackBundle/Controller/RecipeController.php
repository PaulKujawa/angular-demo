<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Recipe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('BarraFrontBundle:Recipe')->findAll();

        if (!$recipes)
            throw $this->createNotFoundException('Recipes not found');

        return $this->render('BarraBackBundle:Recipe:recipes.html.twig', array(
            'recipes' => $recipes
        ));
    }




    public function newRecipeAction($name, $ingredient, $measurement, $amount, $firstCookingStep)
    {
        $recipe = new Recipe();
        $recipe->setName($name)->setRating(50)->setVotes(2);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Recipe could not be inserted');
        }


        $recipeIngredient = new RecipeIngredientController();
        $cookingStep = new CookingStepController();

        $recipeIngredient->newRecipeIngredientAction($recipe, $ingredient, 1, $measurement, $amount);
        $cookingStep->newCookingStepAction($recipe, 1, $firstCookingStep);

        return new Response('Success! Inserted recipe');
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