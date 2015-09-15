<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Agency;
use Barra\BackBundle\Form\Type\AgencyType;
use Barra\FrontBundle\Entity\Repository\AgencyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AgencyController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class AgencyController extends Controller
{
    const RANGE = 10;

    /**
     * @param int $paginationActive
     * @return Response
     */
    public function indexAction($paginationActive)
    {
        $formInsert     = $this->createForm(new AgencyType(), new Agency());
        $startPos       = ($paginationActive-1)*self::RANGE;
        /** @var AgencyRepository $repo */
        $repo           = $this->getDoctrine()->getManager()->getRepository('BarraFrontBundle:Agency');
        $agencies       = $repo->getSome($startPos, self::RANGE, 'name', 'ASC');
        $paginationCnt  = ceil($repo->count()/self::RANGE);

        return $this->render('BarraBackBundle:Agency:agencies.html.twig', [
            'paginationActive'  => $paginationActive,
            'paginationCnt'     => $paginationCnt,
            'agencies'          => $agencies,
            'form'              => $formInsert->createView(),
        ]);
    }
}
