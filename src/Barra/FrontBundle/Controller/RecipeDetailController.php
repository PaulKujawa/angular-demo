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

        $cookings           = $em->getRepository('BarraFrontBundle:Cooking')->findByRecipe($recipe, array('position'=>'ASC'));
        $ingredients  = $em->getRepository('BarraFrontBundle:Ingredient')->findByRecipe($recipe, array('position'=>'ASC'));
        $macros = $this->calculateMakros($ingredients);

        return $this->render('BarraFrontBundle:Recipe:recipe.html.twig', array(
            'recipe'            => $recipe,
            'macros'            => $macros,
            'cookings'          => $cookings,
            'ingredients' => $ingredients,
        ));
    }



    private function calculateMakros($ingredients) {
        $macros = [
            'kcal' => 0,
            'carbs' => 0,
            'protein' => 0,
            'fat' => 0
        ];

        foreach($ingredients as $ingredient) {
            if (! is_null($ingredient->getAmount())) {
                if ($ingredient->getMeasurement()->getGr() != 0) /* eg pieces or bags */
                    $gr = $ingredient->getAmount();
                else
                    $gr = $ingredient->getProduct()->getGr();

                $product          = $ingredient->getProduct();
                $macros['kcal']     += $gr*$product->getKcal()/100;
                $macros['carbs']    += $gr*$product->getCarbs()/100;
                $macros['protein']  += $gr*$product->getProtein()/100;
                $macros['fat']      += $gr*$product->getFat()/100;
            }
        }
        return $macros;
    }
}