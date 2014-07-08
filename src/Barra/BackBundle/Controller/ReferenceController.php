<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Reference;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\DateTime;

class ReferenceController extends Controller
{
    public function indexAction(Request $request)
    {
        $reference = new Reference();
        $form = $this->createForm(new MeasurementType(), $reference);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $sqlError = $this->newReferenceAction($reference);

            if ($sqlError)
                return new Response($sqlError);
            else
                return $this->redirect($this->generateUrl('barra_back_references'));
        }

        $em = $this->getDoctrine()->getManager();
        $references = $em->getRepository('BarraFrontBundle:Measurement')->findAll();

        return $this->render('BarraBackBundle:Measurement:references.html.twig', array(
                'references' => $references,
                'form' => $form->createView()
            ));
    }

    public function newReferenceAction($reference)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($reference);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('reference could not be inserted');
        }
        return null;
    }


    public function deleteMeasurementAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $measurement = $em->getRepository('BarraFrontBundle:Measurement')->find($id);

        if (!$measurement)
            throw $this->createNotFoundException('Measurement not found');
        $em->remove($measurement);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Measurement could not be deleted');
        }

        return $this->redirect($this->generateUrl('barra_back_measurements'));
    }

    /* TODO pk should be just website without company */
    public function deleteReferenceAction($company, $website)
    {
        $em = $this->getDoctrine()->getManager();
        $reference = $em->getRepository('BarraFrontBundle:Reference')->findOneBy(array(
            'company'=>$company, 'website'=>$website)
        );

        if (!$reference)
            throw $this->createNotFoundException('Reference not found');

        $em->remove($reference);
        $em->flush();
        return new Response('Success! Deleted reference');
    }
}