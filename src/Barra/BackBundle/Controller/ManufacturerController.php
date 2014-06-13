<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Manufacturer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ManufacturerController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $manufacturers = $em->getRepository('BarraFrontBundle:Manufacturer')->findAll();

        if (!$manufacturers)
            throw $this->createNotFoundException('Manufacturers not found');

        return $this->render('BarraBackBundle:Manufacturer:manufacturers.html.twig', array(
           'manufacturers' => $manufacturers
        ));
    }


    public function newManufacturer($name)
    {
        $manufacturer = new Manufacturer();
        $manufacturer->setName($name);

        $em = $this->getDoctrine()->getManager();
        $em->persist($manufacturer);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Manufacturer could not be inserted');
        }
        return new Response('Success! Inserted manufacturer');
    }


    public function updateManufacturer($id, $name)
    {
        $em = $this->getDoctrine()->getManager();
        $Manufacturer = $em->getRepository('BarraFrontBundle:Manufacturer')->find($id);
        $Manufacturer->setName($name);
        $em->flush();
        return new Response('Success! Updated manufacturer');
    }


    public function deleteManufacturerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $manufacturer = $em->getRepository('BarraFrontBundle:Manufacturer')->find($id);

        if (!$manufacturer)
            throw $this->createNotFoundException('Manufacturer with id '.$id.' not found');

        $tmp = $manufacturer->getId();
        $em->remove($manufacturer);
        $em->flush();
        return new Response('Success! Deleted manufacturer with id '.$tmp);
    }
}