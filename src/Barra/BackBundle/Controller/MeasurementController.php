<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Measurement;
use Barra\BackBundle\Form\Type\MeasurementType;
use Barra\BackBundle\Form\Type\MeasurementUpdateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MeasurementController extends Controller
{
    public function indexAction(Request $request)
    {
        $measurement = new Measurement();
        $formInsert = $this->createForm(new MeasurementType(), $measurement);
        $formInsert->handleRequest($request);

        if ($formInsert->isValid()) {
            $sqlError = $this->newMeasurementAction($measurement);

            if ($sqlError)
                return new Response($sqlError);
            else
                return $this->redirect($this->generateUrl('barra_back_recipes'));
        }

        $em = $this->getDoctrine()->getManager();
        $measurements = $em->getRepository('BarraFrontBundle:Measurement')->findAll();
        $formUpdate = $this->createForm(new MeasurementUpdateType(), $measurement);


        return $this->render('BarraBackBundle:Measurement:measurements.html.twig', array(
            'measurements' => $measurements,
            'formInsert' => $formInsert->createView(),
            'formUpdate' => $formUpdate->createView()
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



    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('formMeasurementUpdate')['id'];
        $measurement = $em->getRepository('BarraFrontBundle:Measurement')->find($id);

        if (!$measurement) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        $formUpdate = $this->createForm(new MeasurementUpdateType(), $measurement);
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
        $measurement = $em->getRepository('BarraFrontBundle:Measurement')->find($id);

        if (!$measurement)
            throw $this->createNotFoundException('Measurement not found');

        $em->remove($measurement);
        $em->flush();

        return $this->redirect($this->generateUrl('barra_back_measurements'));
    }
}