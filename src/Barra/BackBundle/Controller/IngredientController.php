<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Ingredient;
use Barra\BackBundle\Form\Type\IngredientType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IngredientController extends Controller
{
    public function indexAction(Request $request)
    {
        // Form
        $ingredient = new Ingredient();
        $form = $this->createForm(new IngredientType(), $ingredient);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $sqlError = $this->newIngredientAction($ingredient);

            if ($sqlError)
                return new Response($sqlError);
            else
                return $this->redirect($this->generateUrl('barra_back_recipes'));
        }

        // Overview
        $em = $this->getDoctrine()->getManager();
        $ingredients = $em->getRepository('BarraFrontBundle:Ingredient')->findAll();

        return $this->render('BarraBackBundle:Ingredient:ingredients.html.twig', array(
                'ingredients' => $ingredients,
                'form' => $form->createView()
            ));
    }


    public function newIngredientAction($ingredient)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($ingredient);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Ingredient could not be inserted');
        }
        return null;
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