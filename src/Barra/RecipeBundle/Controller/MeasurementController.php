<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Form\Type\MeasurementType;
use Barra\RecipeBundle\Entity\Measurement;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MeasurementController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Controller
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

        return $this->render('BarraRecipeBundle:Measurement:measurements.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $this->getPaginationPages(),
            'form'      => $form->createView(),
        ]);
    }
}
