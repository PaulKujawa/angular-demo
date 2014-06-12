<?php

namespace Barra\FrontBundle\Controller;

use Barra\FrontBundle\Entity\Recipe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    public function indexAction()
    {
        $recipes = $this->getDoctrine()->getRepository('BarraFrontBundle:Recipe')->findAll();
        if ($recipes)
            return $this->render('BarraFrontBundle:Recipe:recipes.html.twig', array('recipes' => $recipes));

        return new Response('No recipes found.');
    }


    public function showRecipeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($id);

        if (!$recipe)
            throw $this->createNotFoundException('Recipe with id '.$id.' not found');

        $cookingSteps = $em->getRepository('BarraFrontBundle:CookingStep')->findBy(
            array('recipe'=>$recipe), array('step'=>'ASC'));


        return $this->render('BarraFrontBundle:Recipe:recipe.html.twig', array(
            'recipe' => $recipe,
            'cookingSteps'=> $cookingSteps
        ));
    }
}
