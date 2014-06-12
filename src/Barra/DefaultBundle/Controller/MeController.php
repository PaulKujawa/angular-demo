<?php

namespace Barra\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MeController extends Controller
{
    public function indexAction($lang)
    {
        return $this->render('BarraDefaultBundle:Me:me.html.twig');
    }
}
