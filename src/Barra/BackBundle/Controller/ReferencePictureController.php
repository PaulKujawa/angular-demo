<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Reference;
use Barra\FrontBundle\Entity\ReferencePicture;
use Barra\BackBundle\Form\Type\ReferencePictureType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReferencePictureController extends Controller
{
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reference = $em->getRepository('BarraFrontBundle:Reference')->find($id);
        if (!$reference instanceof Reference) {
            throw $this->createNotFoundException('Reference not found');
        }

        $referencePicture     = new ReferencePicture();
        $formReferenceLogo    = $this->createForm(new ReferencePictureType(), $referencePicture);
        $formReferencePicture = $this->createForm(new ReferencePictureType(), $referencePicture);

        $formReferencePicture->get('reference')->setData($reference->getId());

        return $this->render('BarraBackBundle:Reference:referencePictures.html.twig', [
            'reference'             => $reference,
            'formReferenceLogo'     => $formReferenceLogo->createView(),
            'formReferencePicture'  => $formReferencePicture->createView(),
        ]);
    }
}
