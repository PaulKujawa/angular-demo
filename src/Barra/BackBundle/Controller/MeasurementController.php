<?php

namespace Barra\BackBundle\Controller;

use Barra\BackBundle\Form\Type\MeasurementType;
use Barra\FrontBundle\Entity\Measurement;
use Barra\FrontBundle\Entity\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MeasurementController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class MeasurementController extends Controller
{
    const RANGE = 10;

    /**
     * @param int $paginationActive
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($paginationActive)
    {
        $form          = $this->createForm(new MeasurementType(), new Measurement());
        $startPos      = ($paginationActive-1)*self::RANGE;
        /** @var MeasurementRepository $repo */
        $repo          = $this->getDoctrine()->getManager()->getRepository('BarraFrontBundle:Measurement');
        $measurements  = $repo->getSome($startPos, self::RANGE, 'name', 'ASC');
        $paginationCnt = ceil($repo->count()/self::RANGE);

        return $this->render('BarraBackBundle:Measurement:measurements.html.twig', [
            'paginationActive'  => $paginationActive,
            'paginationCnt'     => $paginationCnt,
            'measurements'      => $measurements,
            'form'              => $form->createView(),
        ]);
    }
}