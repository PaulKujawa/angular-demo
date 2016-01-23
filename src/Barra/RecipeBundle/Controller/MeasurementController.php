<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Form\MeasurementType;
use Barra\RecipeBundle\Entity\Measurement;
use Symfony\Component\HttpFoundation\Response;

class MeasurementController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $form = $this->createForm(new MeasurementType(), new Measurement());

        return $this->render(':measurement:measurements.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $this->getPaginationPages(),
            'form'      => $form->createView(),
        ]);
    }
}
