<?php

namespace Barra\DefaultBundle\Controller;

use Barra\DefaultBundle\Entity\Ingredient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    public function newIngredientAction($name, $vegan, $kcal, $protein, $carbs, $sugar, $fat, $gfat, $manufacturerID)
    {
        $manufacturer = $this->getDoctrine()->getRepository('BarraDefaultBundle:Manufacturer')->find($manufacturerID);
        if (!$manufacturer)
            return new Response('Manufacturer with id '.$manufacturerID.' not found');

        $ingredient = new Ingredient();
        $ingredient->setName($name)
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





    public function newRecipeIngredientAction($recipeId, $ingredientId, $measurementId, $amount)
    {
        $id = $this->getDoctrine()->getRepository('BarraDefaultBundle:RecipeIngredient')->findMaxId();

        $recipeIngredient = new RecipeIngredient();
        $recipeIngredient
            ->setId($id)
            ->setRecipe($recipeId)
            ->setIngredient($ingredientId)
            ->setMeasurement($measurementId)
            ->setPosition(1)
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
}
