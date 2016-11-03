<?php

namespace AppBundle\Controller;

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
}
