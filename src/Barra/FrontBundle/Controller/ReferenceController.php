<?php

namespace Barra\FrontBundle\Controller;

use Barra\FrontBundle\Entity\ReferencePicture;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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


    /**
     * for carousel's AJAX calls, all pictures from one reference
     * @param $referenceId
     * @return Response
     */
    public function getAction($referenceId)
    {
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('BarraFrontBundle:ReferencePicture')->findByReference($referenceId);

        $container = array();
        for ($i=0; $i < count($files); $i++) {
            $container[$i]['caption']     = $files[$i]->getTitle();
            $container[$i]['url']       = $files[$i]->getWebPath();
        }

        $ajaxResponse = array("code"=>200, "files"=>$container);
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }
}