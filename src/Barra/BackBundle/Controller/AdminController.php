<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Manufacturer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('BarraFrontBundle:Recipe')->findAll();
        $cookingSteps = $em->getRepository('BarraFrontBundle:CookingStep')->findAll();
        $ingredients = $em->getRepository('BarraFrontBundle:Ingredient')->findAll();
        $manufacturers = $em->getRepository('BarraFrontBundle:Manufacturer')->findAll();

        if (!$manufacturers | !$ingredients)
            throw $this->createNotFoundException('Ingredients not found');

        return $this->render('BarraBackBundle:Admin:admin.html.twig', array(
            'recipes' => $recipes,
            'cookingSteps' => $cookingSteps,
            'ingredients' => $ingredients,
            'manufacturers' => $manufacturers
        ));
    }
}