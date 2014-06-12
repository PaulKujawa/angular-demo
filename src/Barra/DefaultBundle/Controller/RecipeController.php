<?php

namespace Barra\DefaultBundle\Controller;

use Barra\DefaultBundle\Entity\Recipe;
use Barra\DefaultBundle\Entity\CookingStep;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    public function indexAction()
    {
        $recipes = $this->getDoctrine()->getRepository('BarraDefaultBundle:Recipe')->findAll();
        if ($recipes)
            return $this->render('BarraDefaultBundle:Recipe:recipes.html.twig', array('recipes' => $recipes));

        return new Response('No recipes found.');
    }


    public function showRecipeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraDefaultBundle:Recipe')->find($id);

        if (!$recipe)
            throw $this->createNotFoundException('Recipe with id '.$id.' not found');

        $cookingSteps = $em->getRepository('BarraDefaultBundle:CookingStep')->findBy(
            array('recipe'=>$recipe), array('step'=>'ASC'));


        return $this->render('BarraDefaultBundle:Recipe:recipe.html.twig', array(
            'recipe' => $recipe,
            'cookingSteps'=> $cookingSteps
        ));
    }
}
