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
}
