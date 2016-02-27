<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Form\MeasurementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class MeasurementController extends BasicController
{
    /**
     * @Route("/admino/recipes/{page}", name="barra_recipe_measurements", defaults={"page" = 1}, requirements={
     *      "page" = "\d+"
     * })
     *
     * @param int $page
     *
     * @return Response
     */
    public function indexAction($page)
    {
        $form = $this->createForm(MeasurementType::class);

        return $this->render(':measurement:measurements.html.twig', [
            'page' => $page,
            'pages' => $this->getPaginationPages(),
            'form' => $form->createView(),
        ]);
    }
}
