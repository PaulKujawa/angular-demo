<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Manufacturer;
use Barra\BackBundle\Form\Type\ManufacturerType;
use Barra\BackBundle\Form\Type\ManufacturerUpdateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ManufacturerController extends Controller
{
    public function indexAction(Request $request)
    {
        $manufacturer = new Manufacturer();
        $formInsert = $this->createForm(new ManufacturerType(), $manufacturer);
        $formInsert->handleRequest($request);

        if ($formInsert->isValid()) {
            $sqlError = $this->newManufacturer($manufacturer);

            if ($sqlError)
                return new Response($sqlError);
            else
                return $this->redirect($this->generateUrl('barra_back_ingredients'));
        }

        $em = $this->getDoctrine()->getManager();
        $manufacturers = $em->getRepository('BarraFrontBundle:Manufacturer')->findAll();
        $formUpdate = $this->createForm(new ManufacturerUpdateType(), $manufacturer, array('action'=>$this->generateUrl('barra_back_manufacturer_update')));


        return $this->render('BarraBackBundle:Manufacturer:manufacturers.html.twig', array(
            'manufacturers' => $manufacturers,
            'formInsert' => $formInsert->createView(),
            'formUpdate' => $formUpdate->createView()
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




    public function updateAction(Request $request)
    {
        $editedData = $request->request->get('editedData');


        if ($editedData == "a") {
            $returnData = array("responseCode"=>400, "content"=>"Not blank please!");
        } else {
            $returnData = array("responseCode"=>200, "content"=>$editedData);
        }

        $returnData = json_encode($returnData);
        return new Response($returnData, 200, array('Content-Type'=>'application/json'));

    }


    /*public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $manufacturer = $em->getRepository('BarraFrontBundle:Manufacturer')->find($request->request->get('formManufacturerUpdate')['id']);
        if (!$manufacturer)
            throw $this->createNotFoundException('Manufacturer not found');

        $formUpdate = $this->createForm(new ManufacturerUpdateType(), $manufacturer);
        $formUpdate->handleRequest($request);

        if ($formUpdate->isValid())
            $em->flush();

        return $this->redirect($this->generateUrl('barra_back_manufacturers'));
    }*/



    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $manufacturer = $em->getRepository('BarraFrontBundle:Manufacturer')->find($id);

        if (!$manufacturer)
            throw $this->createNotFoundException('Manufacturer not found');

        $em->remove($manufacturer);
        $em->flush();

        return $this->redirect($this->generateUrl('barra_back_manufacturers'));
    }
}