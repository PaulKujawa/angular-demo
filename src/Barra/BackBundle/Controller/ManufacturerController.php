<?php

namespace Barra\BackBundle\Controller;

use Barra\BackBundle\Form\Type\ManufacturerType;
use Barra\FrontBundle\Entity\Manufacturer;
use Barra\FrontBundle\Entity\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ManufacturerController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class ManufacturerController extends Controller
{
    const RANGE = 10;

    /**
     * @param int $paginationActive
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($paginationActive)
    {
        $form          = $this->createForm(new ManufacturerType(), new Manufacturer());
        $startPos      = ($paginationActive-1)*self::RANGE;
        /** @var ManufacturerRepository $repo */
        $repo          = $this->getDoctrine()->getManager()->getRepository('BarraFrontBundle:Manufacturer');
        $manufacturers = $repo->getSome($startPos, self::RANGE, 'name', 'ASC');
        $paginationCnt = ceil($repo->count()/self::RANGE);

        return $this->render('BarraBackBundle:Manufacturer:manufacturers.html.twig', [
            'paginationActive'  => $paginationActive,
            'paginationCnt'     => $paginationCnt,
            'manufacturers'     => $manufacturers,
            'form'              => $form->createView(),
        ]);
    }
}
