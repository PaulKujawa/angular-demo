<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Measurement;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MeasurementController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $measurement = $em->getRepository('BarraFrontBundle:Measurement')->findAll();

        if (!$measurement)
            throw $this->createNotFoundException('Measurements not found');

        return $this->render('BarraBackBundle:Measurement:measurements.html.twig', array(
            'measurements' => $measurement
        ));
    }


    public function newMeasurementAction($type, $inGr)
    {
        $measurement = new Measurement($type, $inGr);
        $measurement->setType($type)->setGr($inGr);

        $em = $this->getDoctrine()->getManager();
        $em->persist($measurement);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Measurement could not be inserted');
        }
        return new Response('Success! Inserted measurement');
    }


    public function updateMeasurement($id, $type, $inGr)
    {
        $em = $this->getDoctrine()->getManager();
        $measurement = $em->getRepository('BarraFrontBundle:Measurement')->find($id);
        $measurement->setType($type)->setGr($inGr);
        $em->flush();
        return new Response('Success! Updated measurement');
    }


    public function deleteMeasurementAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $measurement = $em->getRepository('BarraFrontBundle:Measurement')->find($id);

        if (!$measurement)
            throw $this->createNotFoundException('Ingredient with id '.$id.' not found');

        $em->remove($measurement);
        $em->flush();
        return new Response('Success! Deleted measurement with id '.$id);
    }
}