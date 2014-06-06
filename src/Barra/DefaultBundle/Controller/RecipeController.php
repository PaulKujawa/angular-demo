<?php

namespace Barra\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class RecipeController extends Controller
{
    public function listAction()
    {
        return $this->render('BarraDefaultBundle:Default:recipes.html.twig');
    }


    public function showAction($id)
    {
        $dbResponse = true;
        if (!$dbResponse) {
            throw $this->createNotFoundException('This recipe does not exist yet');
        }

        return $this->render('BarraDefaultBundle:Default:recipe.html.twig', array('id' => $id));
    }
}
