<?php

namespace Barra\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReferenceController extends Controller
{
    public function indexAction()
    {
        return $this->render('BarraDefaultBundle:Reference:references.html.twig');
    }


    public function showReferenceAction()
    {
        return $this->render('BarraDefaultBundle:Reference:reference.html.twig');
    }
}
