<?php

namespace Barra\FrontBundle\Controller;

use Barra\FrontBundle\Entity\Ingredient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class RecipeDetailController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Controller
 */
class RecipeDetailController extends Controller
{
    /**
     * @param string $name
     * @return Response
     */
    public function indexAction($name)
    {
        $em     = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->findOneByName(str_replace('_', ' ', $name));

        if (!$recipe) {
            throw $this->createNotFoundException('Recipe not found');
        }

        $cookings       = $em->getRepository('BarraFrontBundle:Cooking')->findByRecipe($recipe, ['position' => 'ASC']);
        $ingredients    = $em->getRepository('BarraFrontBundle:Ingredient')->findByRecipe($recipe, ['position' => 'ASC']);
        $macros         = $this->calculateMakros($ingredients);

        return $this->render('BarraFrontBundle:Recipe:recipe.html.twig', [
            'recipe'      => $recipe,
            'macros'      => $macros,
            'cookings'    => $cookings,
            'ingredients' => $ingredients,
        ]);
    }


    /**
     * @param array $ingredients
     * @return array
     */
    private function calculateMakros(array $ingredients)
    {
        $macros = [
            'kcal'      => 0,
            'carbs'     => 0,
            'protein'   => 0,
            'fat'       => 0,
        ];

        /** @var Ingredient $ingredient */
        foreach ($ingredients as $ingredient) {
            if (! is_null($ingredient->getAmount())) {
                if ($ingredient->getMeasurement()->getGr() != 0) /* eg pieces or bags */
                    $gr = $ingredient->getAmount();
                else {
                    $gr = $ingredient->getProduct()->getGr();
                }

                $product            = $ingredient->getProduct();
                $macros['kcal']     += $gr*$product->getKcal()/100;
                $macros['carbs']    += $gr*$product->getCarbs()/100;
                $macros['protein']  += $gr*$product->getProtein()/100;
                $macros['fat']      += $gr*$product->getFat()/100;
            }
        }

        return $macros;
    }
}
