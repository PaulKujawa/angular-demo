<?php

namespace Barra\DefaultBundle\Controller;

use Barra\DefaultBundle\Entity\Ingredient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
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



    public function deleteRecipesAction($id) // TODO delete just the route
    {
        $em = $this->getDoctrine()->getManager();
        $m = $em->getRepository('BarraDefaultBundle:Manufacturer')->find($id);

        if ($m) {
            $tmp = $m->getId();
            $em->remove($m);
            $em->flush();
            return new Response('Deleted manufacturer with id '.$tmp);
        } else
            return new Response('Manufacturer not found');
    }



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
