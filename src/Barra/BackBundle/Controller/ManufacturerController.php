<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Manufacturer;
use Barra\BackBundle\Form\Type\ManufacturerType;
use Barra\BackBundle\Form\Type\ManufacturerUpdateType;
use Symfony\Component\Form\Form;
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
            $sqlError = $this->add($manufacturer);

            if ($sqlError)
                return new Response($sqlError);
            else
                return $this->redirect($this->generateUrl('barra_back_ingredients'));
        }

        $em = $this->getDoctrine()->getManager();
        $manufacturers = $em->getRepository('BarraFrontBundle:Manufacturer')->findAll();
        $formUpdate = $this->createForm(new ManufacturerUpdateType(), $manufacturer);


        return $this->render('BarraBackBundle:Manufacturer:manufacturers.html.twig', array(
            'manufacturers' => $manufacturers,
            'formInsert' => $formInsert->createView(),
            'formUpdate' => $formUpdate->createView()
        ));
    }



    public function add($manufacturer)
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
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('formManufacturerUpdate')['id'];
        $manufacturer = $em->getRepository('BarraFrontBundle:Manufacturer')->find($id);

        if (!$manufacturer) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        $formUpdate = $this->createForm(new ManufacturerUpdateType(), $manufacturer);
        $formUpdate->handleRequest($request);

        if ($formUpdate->isValid()) {
            $em->flush();
            $ajaxResponse = array("code"=>200, "message"=>"ok");
        } else {
            $validationErrors = $this->getErrorMessages($formUpdate);
            $ajaxResponse = array("code"=>400, "message"=>$validationErrors);
        }

        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    /**
     * @param Form $form
     * @return array[fieldName][number] e.g. array['name'][0]
     */
    private function getErrorMessages(Form $form) {
        $errors = array();
        $formErrors = $form->getErrors();

        foreach ($formErrors as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid())
                $errors[$child->getName()] = $this->getErrorMessages($child);
        }
        return $errors;
    }



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