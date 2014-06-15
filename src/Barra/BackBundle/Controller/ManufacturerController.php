<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Manufacturer;
use Barra\BackBundle\Form\Type\ManufacturerType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ManufacturerController extends Controller
{
    public function indexAction(Request $request)
    {
        // Form
        $manufacturer = new Manufacturer();
        $form = $this->createForm(new ManufacturerType(), $manufacturer);

        $form->handleRequest($request); // sets obj fields after form submit

        if ($form->isValid()) {
            if ($form->get('submit')->isClicked()) // different submit btns possible
                $sqlError = $this->newManufacturer($manufacturer);
            // else DB update

            if ($sqlError)
                return new Response($sqlError);
            else
                return $this->redirect($this->generateUrl('barra_back_ingredients'));
        }


        // Overview
        $em = $this->getDoctrine()->getManager();
        $manufacturers = $em->getRepository('BarraFrontBundle:Manufacturer')->findAll();

        return $this->render('BarraBackBundle:Manufacturer:manufacturers.html.twig', array(
                'manufacturers' => $manufacturers,
                'form' => $form->createView()
            ));
    }


    public function newManufacturer($manufacturer)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($manufacturer);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return 'Manufacturer could not be inserted';
        }
        return null;
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