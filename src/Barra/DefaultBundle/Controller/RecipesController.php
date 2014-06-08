<?php

namespace Barra\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class RecipesController extends Controller
{
    public function showAction()
    {
        return $this->render('BarraDefaultBundle:Recipes:recipes.html.twig');
    }
}
