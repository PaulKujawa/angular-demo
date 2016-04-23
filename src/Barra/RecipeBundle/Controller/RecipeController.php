<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Entity\Cooking;
use Barra\RecipeBundle\Entity\Ingredient;
use Barra\RecipeBundle\Form\CookingType;
use Barra\RecipeBundle\Form\IngredientType;
use Barra\RecipeBundle\Form\PhotoType;
use Barra\RecipeBundle\Form\RecipeType;
use Barra\RecipeBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends Controller
{
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
        $recipes = $this->getDoctrine()->getManager()->getRepository(Recipe::class)->findBy([], ['name' => 'ASC']);

        return $this->render(':recipe/view:recipes.html.twig', [
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
     * @param Ingredient[] $ingredients
     *
     * @return array
     */
    protected function calculateMacros(array $ingredients)
    {
        $ingredients = array_filter($ingredients, function($ingredient) {
            /**
             * @var Ingredient $ingredient
             */
            return null !== $ingredient->getAmount();
        });

        $macros = ['kcal' => 0, 'carbs' => 0, 'protein' => 0, 'fat' => 0];
        /**
         * @var Ingredient $ingredient
         */
        foreach ($ingredients as $ingredient) {
            $gr = 0 !== $ingredient->getMeasurement()->getGr()
                ? $ingredient->getAmount()/100
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
