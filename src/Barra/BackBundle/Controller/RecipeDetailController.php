<?php

namespace Barra\BackBundle\Controller;

use Barra\BackBundle\Form\Type\CookingType;
use Barra\BackBundle\Form\Type\IngredientType;
use Barra\BackBundle\Form\Type\PhotoType;
use Barra\FrontBundle\Entity\Cooking;
use Barra\FrontBundle\Entity\Ingredient;
use Barra\FrontBundle\Entity\Recipe;
use Barra\FrontBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class RecipeDetailController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class RecipeDetailController extends Controller
{
    /**
     * @param string $name
     * @throws NotFoundHttpException
     * @return Response
     */
    public function indexAction($name)
    {
        $recipe = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BarraFrontBundle:Recipe')
            ->findOneByName(str_replace('_', ' ', $name))
        ;

        if (!$recipe instanceof Recipe) {
            throw new NotFoundHttpException();
        }

        $formPicture    = $this->createForm(new PhotoType(), new Photo());
        $formCooking    = $this->createForm(new CookingType(), new Cooking());
        $formIngredient = $this->createForm(new IngredientType(), new Ingredient());

        return $this->render('BarraBackBundle:Recipe:recipeDetail.html.twig', [
            'recipe'            => $recipe,
            'formPicture'       => $formPicture->createView(),
            'formIngredient'    => $formIngredient->createView(),
            'formCooking'       => $formCooking->createView(),
        ]);
    }
}
