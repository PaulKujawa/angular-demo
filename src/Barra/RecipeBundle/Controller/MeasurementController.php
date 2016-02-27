<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Form\MeasurementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class MeasurementController extends BasicController
{
    /**
     * @Route("/recipes/{pageIndex}", name="barra_recipe_measurements", defaults={"pageIndex" = 1}, requirements={
     *      "pageIndex" = "\d+"
     * })
     *
     * @param int $pageIndex
     *
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
