<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Reference;
use Barra\BackBundle\Form\Type\ReferenceType;
use Barra\FrontBundle\Entity\Repository\ReferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ReferenceController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class ReferenceController extends Controller
{
    const RANGE = 10;

    /**
     * @param int $paginationActive
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($paginationActive)
    {
        $form           = $this->createForm(new ReferenceType(), new Reference());
        $startPos       = ($paginationActive-1)*self::RANGE;
        /** @var ReferenceRepository $repo */
        $repo           = $this->getDoctrine()->getManager()->getRepository('BarraFrontBundle:Reference');
        $references     = $repo->getSome($startPos, self::RANGE, 'url', 'ASC');
        $paginationCnt  = ceil($repo->count()/self::RANGE);

        return $this->render('BarraBackBundle:Reference:references.html.twig', [
            'paginationActive'  => $paginationActive,
            'paginationCnt'     => $paginationCnt,
            'references'        => $references,
            'form'              => $form->createView(),
        ]);
    }
}
