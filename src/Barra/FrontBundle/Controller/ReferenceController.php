<?php

namespace Barra\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReferenceController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $references = $em->getRepository('BarraFrontBundle:Reference')->findAll();

        if (!$references)
            throw $this->createNotFoundException('References not found');

        return $this->render('BarraFrontBundle:Reference:references.html.twig', array(
            'references' => $references,
        ));
    }
}
