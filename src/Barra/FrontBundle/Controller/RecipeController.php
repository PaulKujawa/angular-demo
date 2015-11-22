<?php

namespace Barra\FrontBundle\Controller;

use Barra\AdminBundle\Entity\Ingredient;
use Barra\AdminBundle\Entity\Repository\BasicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RecipeController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Controller
 */
class RecipeController extends Controller
{
    const RANGE = 6;

    /**
     * @param int $paginationActive
     * @return Response
     */
    public function indexAction($paginationActive)
    {
        $offset         = ($paginationActive-1)*self::RANGE +1;
        /** @var BasicRepository $repo */
        $repo           = $this->getDoctrine()->getManager()->getRepository('BarraAdminBundle:Recipe');
        $recipes        = $repo->getSome($offset, self::RANGE, "name", "ASC");
        $paginationCnt  = $repo->count();
        $paginationCnt  = ceil($paginationCnt/self::RANGE);

        return $this->render('BarraFrontBundle:Recipe:recipes.html.twig', [
            'paginationActive'  => $paginationActive,
            'paginationCnt'     => $paginationCnt,
            'recipes'           => $recipes,
        ]);
    }


    /**
     * @param string $name
     * @return Response
     */
    public function showRecipeAction($name)
    {
        $em     = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraAdminBundle:Recipe')->findOneByName(str_replace('_', ' ', $name));

        if (null === $recipe) {
            throw $this->createNotFoundException();
        }

        $cookings    = $em->getRepository('BarraAdminBundle:Cooking')->findByRecipe($recipe, ['position' => 'ASC']);
        $ingredients = $em->getRepository('BarraAdminBundle:Ingredient')->findByRecipe($recipe, ['position' => 'ASC']);
        $macros      = $this->calculateMacros($ingredients);

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
    protected function calculateMacros(array $ingredients)
    {
        $macros = [
            'kcal'    => 0,
            'carbs'   => 0,
            'protein' => 0,
            'fat'     => 0,
        ];

        /** @var Ingredient $ingredient */
        foreach ($ingredients as $ingredient) {
            if (null !== $ingredient->getAmount()) {
                if (0 != $ingredient->getMeasurement()->getGr()) { /* eg pieces or bags */
                    $gr = $ingredient->getAmount();
                } else {
                    $gr = $ingredient->getProduct()->getGr();
                }

                $rel                 = $gr/100;
                $product             = $ingredient->getProduct();
                $macros['kcal']     += $rel*$product->getKcal();
                $macros['carbs']    += $rel*$product->getCarbs();
                $macros['protein']  += $rel*$product->getProtein();
                $macros['fat']      += $rel*$product->getFat();
            }
        }

        return $macros;
    }
}
