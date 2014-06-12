<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Manufacturer;
use Barra\FrontBundle\Entity\Ingredient;
use Barra\FrontBundle\Entity\Measurement;
use Barra\FrontBundle\Entity\RecipeIngredient;
use Barra\FrontBundle\Entity\Recipe;
use Barra\FrontBundle\Entity\CookingStep;
use Barra\FrontBundle\Entity\Reference;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('BarraFrontBundle:Recipe')->findAll();
        $cookingSteps = $em->getRepository('BarraFrontBundle:CookingStep')->findAll();
        $ingredients = $em->getRepository('BarraFrontBundle:Ingredient')->findAll();
        $manufacturers = $em->getRepository('BarraFrontBundle:Manufacturer')->findAll();

        if (!$manufacturers | !$ingredients)
            throw $this->createNotFoundException('Ingredients not found');

        return $this->render('BarraBackBundle:Admin:admin.html.twig', array(
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

    private function newMeasurementAction()
    {
        $measurement = new Measurement($type, $inGr);
        $measurement
            ->setTyp($type)
            ->setGr($inGr);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipeIngredient);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Measurement could not be inserted');
        }
        return new Response('Success! Inserted measurement');
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

    private function newReferenceAction()
    {
        $reference = new Reference();
        $reference
            ->setCompany($company)
            ->setDescription($description)
            ->setStarted($started)
            ->setFinished($finished);

        $em = $this->getDoctrine()->getManager();
        $em->persist($reference);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Reference could not be inserted');
        }

        return new Response('Success! Inserted reference');
    }












    // TODO on delelte/update handling missing by entities
    public function deleteManufacturerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $manufacturer = $em->getRepository('BarraFrontBundle:Manufacturer')->find($id);

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
        $ingredient = $em->getRepository('BarraFrontBundle:Ingredient')->find($id);

        if (!$ingredient)
            throw $this->createNotFoundException('Ingredient with id '.$id.' not found');

        $em->remove($ingredient);
        $em->flush();
        return new Response('Success! Deleted ingredient with id '.$id);
    }

    public function deleteMeasurementAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $measurement = $em->getRepository('BarraFrontBundle:Measurement')->find($id);

        if (!$measurement)
            throw $this->createNotFoundException('Ingredient with id '.$id.' not found');

        $em->remove($measurement);
        $em->flush();
        return new Response('Success! Deleted measurement with id '.$id);
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

    public function deleteReferenceAction($company, $website)
    {
        $em = $this->getDoctrine()->getManager();
        $reference = $em->getRepository('BarraFrontBundle:Reference')->findOneBy(array(
            'company'=>$company, 'website'=>$website)
        );

        if (!$reference)
            throw $this->createNotFoundException('Reference not found');

        $em->remove($reference);
        $em->flush();
        return new Response('Success! Deleted reference');
    }

}