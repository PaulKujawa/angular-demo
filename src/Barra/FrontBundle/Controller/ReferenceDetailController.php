<?php

namespace Barra\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReferenceDetailController extends Controller
{
    public function indexAction($website)
    {
        $em = $this->getDoctrine()->getManager();
        $reference = $em->getRepository('BarraFrontBundle:Reference')->findOneByWebsite(str_replace('.', '.', $website));

        if (!$reference)
            throw $this->createNotFoundException('Reference not found');

        return $this->render('BarraFrontBundle:Reference:reference.html.twig', array(
            'reference' => $reference,
        ));
    }
}
