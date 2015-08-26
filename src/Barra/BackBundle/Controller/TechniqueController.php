<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Repository\TechniqueRepository;
use Barra\FrontBundle\Entity\Technique;
use Barra\BackBundle\Form\Type\TechniqueType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class TechniqueController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class TechniqueController extends Controller
{
    const RANGE = 10;

    /**
     * @param int $paginationActive
     * @return Response
     */
    public function indexAction($paginationActive)
    {
        $formInsert     = $this->createForm(new TechniqueType(), new Technique());
        $startPos       = ($paginationActive-1)*self::RANGE;
        /** @var TechniqueRepository $repo */
        $repo           = $this->getDoctrine()->getManager()->getRepository('BarraFrontBundle:Technique');
        $techniques     = $repo->getSome($startPos, self::RANGE, 'name', 'ASC');
        $paginationCnt  = ceil($repo->count()/self::RANGE);

        return $this->render('BarraBackBundle:Technique:techniques.html.twig', [
            'paginationActive'  => $paginationActive,
            'paginationCnt'     => $paginationCnt,
            'techniques'        => $techniques,
            'form'              => $formInsert->createView(),
        ]);
    }
}