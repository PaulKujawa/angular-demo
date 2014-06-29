<?php

namespace Barra\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function indexAction(Request $request)
    {
        $name = 'Paul';
        $translated = $this->get('translator')->trans('hey');

        return $this->render('BarraFrontBundle:Contact:contact.html.twig', array (
           'name'=>$name,
           'count'=>3
        ));
    }
}