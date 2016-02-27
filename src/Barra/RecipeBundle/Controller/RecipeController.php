<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Entity\Cooking;
use Barra\RecipeBundle\Entity\Ingredient;
use Barra\RecipeBundle\Entity\Repository\BasicRepository;
use Barra\RecipeBundle\Form\CookingType;
use Barra\RecipeBundle\Form\IngredientType;
use Barra\RecipeBundle\Form\PhotoType;
use Barra\RecipeBundle\Form\RecipeType;
use Barra\RecipeBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends BasicController
{
    const LIMIT = 6;

    /**
     * @Route("/admino/recipes/{page}", name="barra_recipe_recipes_admin", defaults={"page" = 1}, requirements={
     *      "page" = "\d+"
     * })
     * @param int $page
     *
     * @return Response
     */
    public function recipesAdminAction($page)
    {
        $form = $this->createForm(RecipeType::class);

        return $this->render(':recipe/manage:recipes.html.twig', [
            'page' => $page,
            'pages' => $this->getPaginationPages(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admino/recipes/{name}", name="barra_recipe_recipe_admin")

     * @param string $name
     *
     * @return Response
     */
    public function recipeAdminAction($name)
    {
        $recipe = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BarraRecipeBundle:Recipe')
            ->findOneByName(str_replace('_', ' ', $name));

        if (null === $recipe){
            $this->addFlash('warning', $this->get('translator')->trans('barra.recipe.not_found'));

            return $this->redirectToRoute('barra_recipe_recipes_admin');
        }

        $formPicture = $this->createForm(PhotoType::class);
        $formCooking = $this->createForm(CookingType::class);
        $formIngredient = $this->createForm(IngredientType::class);

        return $this->render(':recipe/manage:recipe.html.twig', [
            'recipe' => $recipe,
            'formPicture' => $formPicture->createView(),
            'formIngredient' => $formIngredient->createView(),
            'formCooking' => $formCooking->createView(),
        ]);
    }

    /**
     * @Route("/recipes/{page}", name="barra_recipe_recipes_public", defaults={"page" = 1}, requirements={
     *      "page" = "\d+"
     * })
     *
     * @param int $page
     *
     * @return Response
     */
    public function recipesPublicAction($page)
    {
        /** @var BasicRepository $repo */
        $offset = ($page-1)*self::LIMIT +1;
        $repo = $this->getDoctrine()->getManager()->getRepository('BarraRecipeBundle:Recipe');
        $recipes = $repo->getSome($offset, self::LIMIT, 'name');
        $pages = $repo->count();
        $pages = ceil($pages/self::LIMIT);

        return $this->render(':recipe/view:recipes.html.twig', [
            'page' => $page,
            'pages' => $pages,
            'recipes' => $recipes,
        ]);
    }

    /**
     * @Route("/recipes/{name}", name="barra_recipe_recipe_public")
     *
     * @param string $name
     *
     * @return Response
     */
    public function recipePublicAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraRecipeBundle:Recipe')->findOneByName(str_replace('_', ' ', $name));

        if (null === $recipe){
            $this->addFlash('warning', $this->get('translator')->trans('barra.recipe.not_found'));

            return $this->redirectToRoute('barra_recipe_recipes_public');
        }

        $cookings = $em->getRepository('BarraRecipeBundle:Cooking')->findByRecipe($recipe, ['position' => 'ASC']);
        $ingredients = $em->getRepository('BarraRecipeBundle:Ingredient')->findByRecipe($recipe, ['position' => 'ASC']);

        return $this->render(':recipe/view:recipe.html.twig', [
            'macros' => $this->calculateMacros($ingredients),
            'recipe' => $recipe,
            'cookings' => $cookings,
            'ingredients' => $ingredients,
        ]);
    }

    /**
     * @param array $ingredients
     *
     * @return array
     */
    protected function calculateMacros(array $ingredients)
    {
        $macros = ['kcal' => 0, 'carbs' => 0, 'protein' => 0, 'fat' => 0];

        $ingredients = array_filter($ingredients, function($ingredient) {
           return null !== $ingredient->getAmount();
        });

        /** @var Ingredient $ingredient */
        foreach ($ingredients as $ingredient) {
            $gr = 0 !== $ingredient->getMeasurement()->getGr()
                ? $ingredient->getAmount()
                : $ingredient->getProduct()->getGr();

            $rel = $gr/100;
            $product = $ingredient->getProduct();
            $macros['kcal'] += $rel*$product->getKcal();
            $macros['carbs'] += $rel*$product->getCarbs();
            $macros['protein'] += $rel*$product->getProtein();
            $macros['fat'] += $rel*$product->getFat();
        }

        return $macros;
    }
}
