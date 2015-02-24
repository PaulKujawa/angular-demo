<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Technique;
use Barra\BackBundle\Form\Type\TechniqueType;
use Barra\BackBundle\Form\Type\Update\TechniqueUpdateType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TechniqueController extends Controller
{
    public function indexAction(Request $request, $paginationActive)
    {
        $technique  = new Technique();
        $formInsert = $this->createForm(new TechniqueType(), $technique);
        $formInsert->handleRequest($request);

        if ($formInsert->isValid()) {
            $sqlError = $this->newTechnique($technique);

            if ($sqlError)
                $formInsert->addError(new FormError($sqlError));
            else
                return $this->redirect($this->generateUrl('barra_back_techniques'));
        }

        $paginationRange = 10;
        $startPos = ($paginationActive-1)*$paginationRange;
        $em = $this->getDoctrine()->getManager();
        $techniques = $em->getRepository('BarraFrontBundle:Technique')->getSome($startPos, $paginationRange);
        $paginationCnt = $em->getRepository('BarraFrontBundle:Technique')->count();
        $paginationCnt = ceil($paginationCnt/$paginationRange);
        $formUpdate = $this->createForm(new TechniqueUpdateType(), new Technique());

        return $this->render('BarraBackBundle:Technique:techniques.html.twig', array(
                'paginationActive' => $paginationActive,
                'paginationCnt' => $paginationCnt,
                'techniques' => $techniques,
                'formInsert' => $formInsert->createView(),
                'formUpdate' => $formUpdate->createView()
            ));
    }



    public function newTechnique($technique)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($technique);

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
        $id = $request->request->get('formTechniqueUpdate')['id'];
        $technique = $em->getRepository('BarraFrontBundle:Technique')->find($id);

        if (!$technique) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        $formUpdate = $this->createForm(new TechniqueUpdateType(), $technique);
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



    public function deleteTechniqueAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $technique = $em->getRepository('BarraFrontBundle:Technique')->find($id);

        if (!$technique)
            throw $this->createNotFoundException('Technique not found');

        $em->remove($technique);
        $em->flush();

        return $this->redirect($this->generateUrl('barra_back_techniques'));
    }
}