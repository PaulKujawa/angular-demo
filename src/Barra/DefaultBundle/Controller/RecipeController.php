<?php

namespace Barra\DefaultBundle\Controller;

use Barra\DefaultBundle\Entity\Ingredient;
use Barra\DefaultBundle\Entity\Manufacturer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    public function showRecipesAction()
    {
        $manufacturer = $this->getDoctrine()->getRepository('BarraDefaultBundle:Manufacturer')->selectOneById(2);

        if (!$manufacturer)
            return new Response('eee');

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
