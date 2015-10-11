<?php

namespace Barra\AdminBundle\Controller;

use Barra\AdminBundle\Entity\Cooking;
use Barra\AdminBundle\Entity\Ingredient;
use Barra\AdminBundle\Entity\Photo;
use Barra\AdminBundle\Form\Type\CookingType;
use Barra\AdminBundle\Form\Type\IngredientType;
use Barra\AdminBundle\Form\Type\PhotoType;
use Barra\AdminBundle\Form\Type\RecipeType;
use Barra\AdminBundle\Entity\Recipe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class RecipeController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Controller
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

        return $this->render('BarraAdminBundle:Recipe:recipes.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $pages,
            'form'      => $form->createView(),
        ]);
    }


    /**
     * @param string $name
     * @return Response
     * @throws NotFoundHttpException
     */
    public function showRecipeAction($name)
    {
        $recipe = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BarraAdminBundle:Recipe')
            ->findOneByName(str_replace('_', ' ', $name))
        ;

        if (!$recipe instanceof Recipe) {
            throw new NotFoundHttpException();
        }

        $formPicture    = $this->createForm(new PhotoType(), new Photo());
        $formCooking    = $this->createForm(new CookingType(), new Cooking());
        $formIngredient = $this->createForm(new IngredientType(), new Ingredient());

        return $this->render('BarraAdminBundle:Recipe:recipe.html.twig', [
            'recipe'            => $recipe,
            'formPicture'       => $formPicture->createView(),
            'formIngredient'    => $formIngredient->createView(),
            'formCooking'       => $formCooking->createView(),
        ]);
    }
}
