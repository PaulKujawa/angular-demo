<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Agency;
use Barra\BackBundle\Form\Type\AgencyType;
use Barra\BackBundle\Form\Type\Update\AgencyUpdateType;


use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AgencyController extends Controller
{
    public function indexAction(Request $request, $paginationActive)
    {
        $agency = new Agency();
        $formInsert = $this->createForm(new AgencyType(), $agency);
        $formInsert->handleRequest($request);

        if ($formInsert->isValid()) {
            $sqlError = $this->newAgency($agency);

            if ($sqlError)
                $formInsert->addError(new FormError($sqlError));
            else
                return $this->redirect($this->generateUrl('barra_back_agencies'));
        }

        $paginationRange = 10;
        $startPos = ($paginationActive-1)*$paginationRange;
        $em = $this->getDoctrine()->getManager();
        $agencies = $em->getRepository('BarraFrontBundle:Agency')->getSome($startPos, $paginationRange);
        $paginationCnt = $em->getRepository('BarraFrontBundle:Agency')->count();
        $paginationCnt = ceil($paginationCnt/$paginationRange);
        $formUpdate = $this->createForm(new AgencyUpdateType(), new Agency());

        return $this->render('BarraBackBundle:Agency:agencies.html.twig', array(
                'paginationActive' => $paginationActive,
                'paginationCnt' => $paginationCnt,
                'agencies' => $agencies,
                'formInsert' => $formInsert->createView(),
                'formUpdate' => $formUpdate->createView()
            ));
    }



    public function newAgency($agency)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($agency);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return $this->get('translator')->trans("back.message.insertError");
        }
        return null;
    }



    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('formAgencyUpdate')['id'];
        $agency = $em->getRepository('BarraFrontBundle:Agency')->find($id);

        if (!$agency) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        $formUpdate = $this->createForm(new AgencyUpdateType(), $agency);
        $formUpdate->handleRequest($request);

        if ($formUpdate->isValid()) {
            try {
                $em->flush();
                $ajaxResponse = array("code"=>200, "message"=>"ok");
            } catch (\Doctrine\DBAL\DBALException $e) {
                $validationErrors = $this->get('translator')->trans("back.message.insertError");
                $ajaxResponse = array("code"=>409, "dbError"=>$validationErrors);
            }
        } else {
            $validationErrors = $this->get('barra_back.formValidation')->getErrorMessages($formUpdate);
            $ajaxResponse = array("code"=>400, "fieldError"=>$validationErrors);
        }

        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    public function deleteAgencyAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $agency = $em->getRepository('BarraFrontBundle:Agency')->find($id);

        if (!$agency)
            throw $this->createNotFoundException('Agency not found');

        $em->remove($agency);
        $em->flush();

        return $this->redirect($this->generateUrl('barra_back_agencys'));
    }
}