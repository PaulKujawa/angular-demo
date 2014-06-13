<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Ingredient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IngredientController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ingredients = $em->getRepository('BarraFrontBundle:Ingredient')->findAll();

        if (!$ingredients)
            throw $this->createNotFoundException('Ingredients not found');

        return $this->render('BarraBackBundle:Ingredient:ingredients.html.twig', array(
            'ingredients' => $ingredients,
        ));
    }


    public function newIngredientAction($name, $vegan, $kcal, $protein, $carbs, $sugar, $fat, $gfat, $manufacturer)
    {
        $ingredient = new Ingredient();
        $ingredient->setName($name)->setVegan($vegan)->setKcal($kcal)->setProtein($protein)->setCarbs($carbs)
            ->setSugar($sugar)->setFat($fat)->setGfat($gfat)->setManufacturer($manufacturer);

        $em = $this->getDoctrine()->getManager();
        $em->persist($ingredient);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Ingredient could not be inserted');
        }
        return new Response('Success! Inserted ingredient');
    }


    public function updateIngredient($id, $name, $vegan, $kcal, $protein, $carbs, $sugar, $fat, $gfat, $manufacturer)
    {
        $em = $this->getDoctrine()->getManager();
        $ingredient = $em->getRepository('BarraFrontBundle:Ingredient')->find($id);
        $ingredient->setName($name)->setVegan($vegan)->setKcal($kcal)->setProtein($protein)->setCarbs($carbs)
            ->setSugar($sugar)->setFat($fat)->setGfat($gfat)->setManufacturer($manufacturer);
        $em->flush();
        return new Response('Success! Updated Ingredient');
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
}