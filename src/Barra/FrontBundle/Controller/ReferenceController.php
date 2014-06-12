<?php

namespace Barra\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReferenceController extends Controller
{
    public function indexAction()
    {
        return $this->render('BarraFrontBundle:Reference:references.html.twig');
    }


    public function showReferenceAction()
    {
        return $this->render('BarraFrontBundle:Reference:reference.html.twig');
    }
}
