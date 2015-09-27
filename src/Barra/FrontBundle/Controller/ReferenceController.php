<?php

namespace Barra\FrontBundle\Controller;

use Barra\AdminBundle\Entity\Repository\ReferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ReferenceController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Controller
 */
class ReferenceController extends Controller
{
    const RANGE = 6;

    /**
     * @param int $paginationActive
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($paginationActive)
    {
        $offset         = ($paginationActive-1)*self::RANGE +1;
        $repo           = $this->getDoctrine()->getManager()->getRepository('BarraAdminBundle:Reference');
        /** @var ReferenceRepository $repo */
        $references     = $repo->getSome($offset, self::RANGE, "finished", "DESC");
        $paginationCnt  = $repo->count();
        $paginationCnt  = ceil($paginationCnt/self::RANGE);

        return $this->render('BarraFrontBundle:Reference:references.html.twig', [
            'paginationActive'  => $paginationActive,
            'paginationCnt'     => $paginationCnt,
            'references'        => $references,
        ]);
    }
}
