<?php

namespace AppBundle\Controller;

use AppBundle\Form\MeasurementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MeasurementController extends Controller
{
    /**
     * @Route("/admino/measurements/{page}", name="app_measurements", defaults={"page" = 1}, requirements={
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
            'form' => $form->createView(),
        ]);
    }
}
