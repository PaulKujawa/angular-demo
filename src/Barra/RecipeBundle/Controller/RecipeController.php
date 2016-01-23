<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Entity\Cooking;
use Barra\RecipeBundle\Entity\Ingredient;
use Barra\RecipeBundle\Entity\Photo;
use Barra\RecipeBundle\Entity\Repository\BasicRepository;
use Barra\RecipeBundle\Form\CookingType;
use Barra\RecipeBundle\Form\IngredientType;
use Barra\RecipeBundle\Form\PhotoType;
use Barra\RecipeBundle\Form\RecipeType;
use Barra\RecipeBundle\Entity\Recipe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class RecipeController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Controller
 */
class RecipeController extends BasicController
{
    const LIMIT = 6;

    /**
     * @param int $pageIndex
     * @return Response
     */
    public function recipesAdminAction($pageIndex)
    {
        $form = $this->createForm(new RecipeType(), new Recipe());

        return $this->render('BarraRecipeBundle:Recipe:recipesAdmin.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $this->getPaginationPages(),
            'form'      => $form->createView(),
        ]);
    }

    /**
     * @param string $name
     * @return Response
     */
    public function recipeAdminAction($name)
    {
        $recipe = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BarraRecipeBundle:Recipe')
            ->findOneByName(str_replace('_', ' ', $name));

        if (!$recipe instanceof Recipe) {
            throw new NotFoundHttpException();
        }

        $formPicture    = $this->createForm(new PhotoType(), new Photo());
        $formCooking    = $this->createForm(new CookingType(), new Cooking());
        $formIngredient = $this->createForm(new IngredientType(), new Ingredient());

        return $this->render('BarraRecipeBundle:Recipe:recipeAdmin.html.twig', [
            'recipe'            => $recipe,
            'formPicture'       => $formPicture->createView(),
            'formIngredient'    => $formIngredient->createView(),
            'formCooking'       => $formCooking->createView(),
        ]);
    }

    /**
     * @param int $pageIndex
     * @return Response
     */
    public function recipesPublicAction($pageIndex)
    {
        /** @var BasicRepository $repo */
        $offset     = ($pageIndex-1)*self::LIMIT +1;
        $repo       = $this->getDoctrine()->getManager()->getRepository('BarraRecipeBundle:Recipe');
        $recipes    = $repo->getSome($offset, self::LIMIT, 'name');
        $pages      = $repo->count();
        $pages      = ceil($pages/self::LIMIT);

        return $this->render('BarraRecipeBundle:Recipe:recipesPublic.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $pages,
            'recipes'   => $recipes,
        ]);
    }

    /**
     * @param string $name
     * @return Response
     */
    public function recipePublicAction($name)
    {
        $em     = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraRecipeBundle:Recipe')->findOneByName(str_replace('_', ' ', $name));

        if (null === $recipe) {
            throw $this->createNotFoundException();
        }

        $cookings    = $em->getRepository('BarraRecipeBundle:Cooking')->findByRecipe($recipe, ['position' => 'ASC']);
        $ingredients = $em->getRepository('BarraRecipeBundle:Ingredient')->findByRecipe($recipe, ['position' => 'ASC']);
        $macros      = $this->calculateMacros($ingredients);

        return $this->render('BarraRecipeBundle:Recipe:recipePublic.html.twig', [
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
