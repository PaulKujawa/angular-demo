<?php

namespace Barra\AdminBundle\Controller;

use Barra\AdminBundle\Form\Type\MeasurementType;
use Barra\AdminBundle\Entity\Measurement;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MeasurementController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Controller
 */
class MeasurementController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $form = $this->createForm(new MeasurementType(), new Measurement());

        return $this->render('BarraAdminBundle:Measurement:measurements.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $this->getPaginationPages(),
            'form'      => $form->createView(),
        ]);
    }
}
