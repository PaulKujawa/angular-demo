<?php

namespace Barra\DefaultBundle\Controller;

use Barra\DefaultBundle\Entity\Manufacturer;
use Barra\DefaultBundle\Entity\Ingredient;
use Barra\DefaultBundle\Entity\Measurement;
use Barra\DefaultBundle\Entity\RecipeIngredient;
use Barra\DefaultBundle\Entity\Recipe;
use Barra\DefaultBundle\Entity\CookingStep;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('BarraDefaultBundle:Recipe')->findAll();
        $cookingSteps = $em->getRepository('BarraDefaultBundle:CookingStep')->findAll();
        $ingredients = $em->getRepository('BarraDefaultBundle:Ingredient')->findAll();
        $manufacturers = $em->getRepository('BarraDefaultBundle:Manufacturer')->findAll();

        if (!$manufacturers | !$ingredients)
            throw $this->createNotFoundException('Ingredients not found');

        return $this->render('BarraDefaultBundle:Admin:admin.html.twig', array(
            'recipes' => $recipes,
            'cookingSteps' => $cookingSteps,
            'ingredients' => $ingredients,
            'manufacturers' => $manufacturers
        ));
    }


















    public function newManufacturer($name)
    {
        $manufacturer = new Manufacturer();
        $manufacturer->setName($name);

        $em = $this->getDoctrine()->getManager();
        $em->persist($manufacturer);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Manufacturer could not be inserted');
        }
        return new Response('Success! Inserted manufacturer');
    }

    private function newIngredientAction($name, $vegan, $kcal, $protein, $carbs, $sugar, $fat, $gfat, $manufacturer)
    {
        $ingredient = new Ingredient();
        $ingredient
            ->setName($name)
            ->setVegan($vegan)
            ->setKcal($kcal)
            ->setProtein($protein)
            ->setCarbs($carbs)
            ->setSugar($sugar)
            ->setFat($fat)
            ->setGfat($gfat)
            ->setManufacturer($manufacturer);

        $em = $this->getDoctrine()->getManager();
        $em->persist($ingredient);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Ingredient could not be inserted');
        }
        return new Response('Success! Inserted ingredient');
    }

    private function newRecipeIngredientAction($recipe, $ingredient, $position, $measurement, $amount)
    {
        $recipeIngredient = new RecipeIngredient();
        $recipeIngredient
            ->setRecipe($recipe)
            ->setIngredient($ingredient)
            ->setPosition($position)
            ->setMeasurement($measurement)
            ->setAmount($amount);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipeIngredient);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Recipe relation could not be inserted');
        }
        return new Response('Success! Inserted Relation');
    }

    private function newCookingStepAction($recipe, $step, $description)
    {
        $cookingStep = new CookingStep();
        $cookingStep
            ->setRecipe($recipe)
            ->setStep($step)
            ->setDescription($description);

        $em = $this->getDoctrine()->getManager();
        $em->persist($cookingStep);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Cooking step could not be inserted');
        }
        return new Response('Success! Inserted cooking step');
    }

    private function newRecipeAction($name, $ingredient, $measurement, $amount, $firstCookingStep)
    {
        $recipe = new Recipe();
        $recipe
            ->setName($name)
            ->setRating(50)
            ->setVotes(2);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Recipe could not be inserted');
        }

        $this->newRecipeIngredientAction($recipe, $ingredient, 1, $measurement, $amount);
        $this->newCookingStepAction($recipe, 1, $firstCookingStep);
        return new Response('Success! Inserted recipe');
    }











    // TODO on delelte/update handling missing by entities
    public function deleteManufacturerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $manufacturer = $em->getRepository('BarraDefaultBundle:Manufacturer')->find($id);

        if (!$manufacturer)
            throw $this->createNotFoundException('Manufacturer with id '.$id.' not found');

        $tmp = $manufacturer->getId();
        $em->remove($manufacturer);
        $em->flush();
        return new Response('Success! Deleted manufacturer with id '.$tmp);
    }

    public function deleteIngredientAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ingredient = $em->getRepository('BarraDefaultBundle:Ingredient')->find($id);

        if (!$ingredient)
            throw $this->createNotFoundException('Ingredient with id '.$id.' not found');

        $em->remove($ingredient);
        $em->flush();
        return new Response('Success! Deleted ingredient with id '.$id);
    }

    public function deleteRecipeIngredientAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeIngredient = $em->getRepository('BarraDefaultBundle:RecipeIngredient')->find($id);

        if (!$recipeIngredient)
            throw $this->createNotFoundException('Relation with id '.$id.' not found');

        $em->remove($recipeIngredient);
        $em->flush();
        return new Response('Success! Deleted relation with id '.$id);
    }

    public function deleteRecipeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraDefaultBundle:Recipe')->find($id);

        if (!$recipe)
            throw $this->createNotFoundException('Recipe with id '.$id.' not found');

        $em->remove($recipe);
        $em->flush();
        return new Response('Success! Deleted recipe with id '.$id);
    }

    public function deleteCookingStepAction($recipe, $step)
    {
        $em = $this->getDoctrine()->getManager();
        $cooking = $em->getRepository('BarraDefaultBundle:CookingStep')->findOneBy(array(
            'recipe'=>$recipe, 'step'=>$step)
        );

        if (!$cooking)
            throw $this->createNotFoundException('Cooking step not found');

        $em->remove($cooking);
        $em->flush();
        return new Response('Success! Deleted cooking step');
    }
}