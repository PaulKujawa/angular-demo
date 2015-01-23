<?php

namespace Barra\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReferenceController extends Controller
{
    public function indexAction($paginationActive)
    {
        $paginationRange = 4;
        $startPos = ($paginationActive-1)*$paginationRange;
        $em = $this->getDoctrine()->getManager();
        $references = $em->getRepository('BarraFrontBundle:Reference')->getSome($startPos, $paginationRange);
        $paginationCnt = $em->getRepository('BarraFrontBundle:Reference')->count();
        $paginationCnt = ceil($paginationCnt/$paginationRange);

        if (!$references)
            throw $this->createNotFoundException('References not found');

        return $this->render('BarraFrontBundle:Reference:references.html.twig', array(
                'paginationActive' => $paginationActive,
                'paginationCnt' => $paginationCnt,
                'references' => $references,
            ));
    }
}