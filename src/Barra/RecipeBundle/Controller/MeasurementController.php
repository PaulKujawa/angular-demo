<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Form\MeasurementType;
use Symfony\Component\HttpFoundation\Response;

class MeasurementController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $form = $this->createForm(MeasurementType::class);

        return $this->render(':measurement:measurements.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $this->getPaginationPages(),
            'form'      => $form->createView(),
        ]);
    }
}
