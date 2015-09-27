<?php

namespace Barra\AdminBundle\Controller;

use Barra\AdminBundle\Entity\Reference;
use Barra\AdminBundle\Entity\Screenshot;
use Barra\AdminBundle\Form\Type\ScreenshotType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ScreenshotController extends Controller
{
    public function indexAction($id)
    {
        $reference = $this->getDoctrine()->getManager()->getRepository('BarraAdminBundle:Reference')->find($id);

        if (!$reference instanceof Reference) {
            throw $this->createNotFoundException();
        }

        $formReferenceLogo  = $this->createForm(new ScreenshotType(), new Screenshot());
        $formScreenshot     = $this->createForm(new ScreenshotType(), new Screenshot());

        $formScreenshot->get('reference')->setData($reference->getId());

        return $this->render('BarraAdminBundle:Reference:screenshots.html.twig', [
            'reference'         => $reference,
            'formReferenceLogo' => $formReferenceLogo->createView(),
            'formScreenshot'    => $formScreenshot->createView(),
        ]);
    }
}
