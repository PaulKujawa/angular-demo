<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cooking;
use AppBundle\Entity\Ingredient;
use AppBundle\Form\CookingType;
use AppBundle\Form\IngredientType;
use AppBundle\Form\PhotoType;
use AppBundle\Form\RecipeType;
use AppBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends Controller
{
    /**
     * @Security("is_authenticated()")
     *
     * @Route("/admino/recipes/{page}", name="app_recipes_admin", defaults={"page" = 1}, requirements={
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
     * @Security("is_authenticated()")
     *
     * @Route("/admino/recipes/{name}", name="app_recipe_admin")

     * @param string $name
     *
     * @return Response
     */
    public function recipeAdminAction($name)
    {
        $recipe = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Recipe')
            ->findOneByName(str_replace('_', ' ', $name));

        if (null === $recipe){
            $this->addFlash('warning', $this->get('translator')->trans('barra.recipe.not_found'));

            return $this->redirectToRoute('app_recipes_admin');
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
     * @Route("/recipes/{page}", name="app_recipes_public", defaults={"page" = 1}, requirements={
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
     * @Route("/recipes/{name}", name="app_recipe_public")
     *
     * @param string $name
     *
     * @return Response
     */
    public function recipePublicAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('AppBundle:Recipe')->findOneByName(str_replace('_', ' ', $name));

        if (null === $recipe){
            $this->addFlash('warning', $this->get('translator')->trans('barra.recipe.not_found'));

            return $this->redirectToRoute('app_recipes_public');
        }

        $cookings = $em->getRepository('AppBundle:Cooking')->findByRecipe($recipe, ['position' => 'ASC']);
        $ingredients = $em->getRepository('AppBundle:Ingredient')->findByRecipe($recipe, ['position' => 'ASC']);

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
