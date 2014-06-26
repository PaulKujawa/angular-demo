<?php

namespace Barra\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MeController extends Controller
{
    public function indexAction()
    {
        return $this->render('BarraFrontBundle:Me:me.html.twig');
    }
}
