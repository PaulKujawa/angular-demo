<?php

namespace Barra\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeIngredientController extends Controller
{
    public function newRecipeIngredientAction($recipe, $ingredient, $position, $measurement, $amount)
    {
        $recipeIngredient = new RecipeIngredient();
        $recipeIngredient->setRecipe($recipe)->setIngredient($ingredient)->setPosition($position)
            ->setMeasurement($measurement)->setAmount($amount);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipeIngredient);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Recipe relation could not be inserted');
        }
        return new Response('Success! Inserted Relation');
    }


    public function updateRecipeIngredient($id, $recipe, $ingredient, $position, $measurement, $amount)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeIngredient = $em->getRepository('BarraFrontBundle:RecipeIngredient')->find($id);
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
}