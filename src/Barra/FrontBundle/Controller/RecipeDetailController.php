<?php

namespace Barra\FrontBundle\Controller;

use Barra\FrontBundle\Entity\Recipe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeDetailController extends Controller
{
    public function indexAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->findOneByName(str_replace('_', ' ', $name));

        if (!$recipe)
            throw $this->createNotFoundException('Recipe not found');

        $cookingSteps = $em->getRepository('BarraFrontBundle:CookingStep')->findBy(
            array('recipe'=>$recipe), array('step'=>'ASC'));


        return $this->render('BarraFrontBundle:Recipe:recipe.html.twig', array(
            'recipe' => $recipe,
            'cookingSteps'=> $cookingSteps
        ));
    }
}
