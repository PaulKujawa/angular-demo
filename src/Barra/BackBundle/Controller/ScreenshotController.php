<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Reference;
use Barra\FrontBundle\Entity\Screenshot;
use Barra\BackBundle\Form\Type\ScreenshotType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ScreenshotController extends Controller
{
    public function indexAction($id)
    {
        $reference = $this->getDoctrine()->getManager()->getRepository('BarraFrontBundle:Reference')->find($id);

        if (!$reference instanceof Reference) {
            throw $this->createNotFoundException('Reference not found');
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
