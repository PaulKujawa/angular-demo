<?php

namespace Barra\BackBundle\Controller;

use Barra\BackBundle\Entity\Cooking;
use Barra\BackBundle\Entity\Ingredient;
use Barra\BackBundle\Entity\Photo;
use Barra\BackBundle\Form\Type\CookingType;
use Barra\BackBundle\Form\Type\IngredientType;
use Barra\BackBundle\Form\Type\PhotoType;
use Barra\BackBundle\Form\Type\RecipeType;
use Barra\BackBundle\Entity\Recipe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class RecipeController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class RecipeController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $pages = $this->getPaginationPages('Recipe', 10);
        $form  = $this->createForm(new RecipeType(), new Recipe());

        return $this->render('BarraBackBundle:Recipe:recipes.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $pages,
            'form'      => $form->createView(),
        ]);
    }


    /**
     * @param string $name
     * @throws NotFoundHttpException
     * @return Response
     */
    public function showRecipeAction($name)
    {
        $recipe = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BarraBackBundle:Recipe')
            ->findOneByName(str_replace('_', ' ', $name))
        ;

        if (!$recipe instanceof Recipe) {
            throw new NotFoundHttpException();
        }

        $formPicture    = $this->createForm(new PhotoType(), new Photo());
        $formCooking    = $this->createForm(new CookingType(), new Cooking());
        $formIngredient = $this->createForm(new IngredientType(), new Ingredient());

        return $this->render('BarraBackBundle:Recipe:recipe.html.twig', [
            'recipe'            => $recipe,
            'formPicture'       => $formPicture->createView(),
            'formIngredient'    => $formIngredient->createView(),
            'formCooking'       => $formCooking->createView(),
        ]);
    }
}
