<?php

namespace Barra\DefaultBundle\Controller;

use Barra\DefaultBundle\Entity\Ingredient;
use Barra\DefaultBundle\Entity\Manufacturer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{




    // show
    // add
    // remove -> adminRepo
    // update -> adminRepo



    public function showRecipesAction()
    {
        $recipes = $this->getDoctrine()->getRepository('BarraDefaultBundle:Recipe')->findAll();
        if ($recipes)
            return $this->render('BarraDefaultBundle:Recipe:recipes.html.twig', array('recipes' => $recipes));
        else
            return new Response('No recipes found.');
    }


    public function newRecipeAction()
    {
        // TODO

    }

    public function insertIngredientAction($name, $vegan, $kcal, $protein, $carbs, $sugar, $fat, $gfat, $manufacturerID)
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

        return new Response('Insert successfully');
    }



    public function deleteRecipeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraDefaultBundle:Recipe')->find($id);

        if ($recipe) {
            $em->remove($recipe);
            $em->flush();
            return new Response('Deleted recipe with id '.$id);
        } else
            return new Response('Recipe not found.');
    }







    /*public function showRecipesAction()
    {
        $manufacturer = $this->getDoctrine()->getRepository('BarraDefaultBundle:Manufacturer')->selectOneById(2);

        if (!$manufacturer)
            return new Response('Manufacturer with id 2 not found');

        $ingredient = new Ingredient();
        $ingredient->setName('potato')
            ->setVegan(true)
            ->setKcal('1')
            ->setProtein('3')
            ->setCarbs('1')
            ->setSugar('0.9')
            ->setFat('2')
            ->setGfat('1.9')
            ->setManufacturer($manufacturer);


        $em = $this->getDoctrine()->getManager();
        $em->persist($ingredient);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('DBAL Exception thrown');
        }

        return new Response('Created with id '.$ingredient->getId());
    }*/






    public function showRecipeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraDefaultBundle:Recipe')->selectRecipeById($id);

        if (!$recipe) {
            throw $this->createNotFoundException('Recipe with id '.$id.' does not exist yet');
        }

        return $this->render('BarraDefaultBundle:Recipe:recipe.html.twig', array('recipe' => $recipe));
    }
}
