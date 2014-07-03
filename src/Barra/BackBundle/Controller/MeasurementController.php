<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Measurement;
use Barra\BackBundle\Form\Type\MeasurementType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MeasurementController extends Controller
{
    public function indexAction(Request $request)
    {
        $measurement = new Measurement();
        $form = $this->createForm(new MeasurementType(), $measurement);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $sqlError = $this->newMeasurementAction($measurement);

            if ($sqlError)
                return new Response($sqlError);
            else
                return $this->redirect($this->generateUrl('barra_back_recipes'));
        }

        $em = $this->getDoctrine()->getManager();
        $measurements = $em->getRepository('BarraFrontBundle:Measurement')->findAll();

        return $this->render('BarraBackBundle:Measurement:measurements.html.twig', array(
            'measurements' => $measurements,
            'form' => $form->createView()
        ));
    }



    public function newMeasurementAction($measurement)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($measurement);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Measurement could not be inserted');
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
}