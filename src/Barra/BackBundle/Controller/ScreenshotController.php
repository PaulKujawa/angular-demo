<?php

namespace Barra\BackBundle\Controller;

use Barra\BackBundle\Entity\Reference;
use Barra\BackBundle\Entity\Screenshot;
use Barra\BackBundle\Form\Type\ScreenshotType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ScreenshotController extends Controller
{
    public function indexAction($id)
    {
        $reference = $this->getDoctrine()->getManager()->getRepository('BarraBackBundle:Reference')->find($id);

        if (!$reference instanceof Reference) {
            throw $this->createNotFoundException();
        }

        $formReferenceLogo  = $this->createForm(new ScreenshotType(), new Screenshot());
        $formScreenshot     = $this->createForm(new ScreenshotType(), new Screenshot());

        $formScreenshot->get('reference')->setData($reference->getId());

        return $this->render('BarraBackBundle:Reference:screenshots.html.twig', [
            'reference'         => $reference,
            'formReferenceLogo' => $formReferenceLogo->createView(),
            'formScreenshot'    => $formScreenshot->createView(),
        ]);
    }
}
