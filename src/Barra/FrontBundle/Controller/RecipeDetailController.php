<?php

namespace Barra\FrontBundle\Controller;

use Barra\FrontBundle\Entity\Recipe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeDetailController extends Controller
{
    public function indexAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe             = $em->getRepository('BarraFrontBundle:Recipe')->findOneByName(str_replace('_', ' ', $name));

        if (!$recipe)
            throw $this->createNotFoundException('Recipe not found');

        $cookingSteps       = $em->getRepository('BarraFrontBundle:CookingStep')->findByRecipe($recipe, array('position'=>'ASC'));
        $recipeIngredients  = $em->getRepository('BarraFrontBundle:RecipeIngredient')->findByRecipe($recipe, array('position'=>'ASC'));
        $macros = $this->calculateMakros($recipeIngredients);

        return $this->render('BarraFrontBundle:Recipe:recipe.html.twig', array(
            'recipe'            => $recipe,
            'macros'            => $macros,
            'cookingSteps'      => $cookingSteps,
            'recipeIngredients' => $recipeIngredients,
        ));
    }



    private function calculateMakros($recipeIngredients) {
        $macros = [
            'kcal' => 0,
            'carbs' => 0,
            'protein' => 0,
            'fat' => 0
        ];

        foreach($recipeIngredients as $recipeIngredient) {
            if (! is_null($recipeIngredient->getAmount())) {
                if ($recipeIngredient->getMeasurement()->getGr() != 0) /* eg pieces or bags */
                    $gr = $recipeIngredient->getAmount();
                else
                    $gr = $recipeIngredient->getIngredient()->getGr();

                $ingredient          = $recipeIngredient->getIngredient();
                $macros['kcal']     += $gr*$ingredient->getKcal()/100;
                $macros['carbs']    += $gr*$ingredient->getCarbs()/100;
                $macros['protein']  += $gr*$ingredient->getProtein()/100;
                $macros['fat']      += $gr*$ingredient->getFat()/100;
            }
        }
        return $macros;
    }
}