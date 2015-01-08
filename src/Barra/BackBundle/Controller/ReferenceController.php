<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Reference;
use Barra\BackBundle\Form\Type\ReferenceType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReferenceController extends Controller
{
    public function indexAction(Request $request, $paginationActive)
    {
        $reference = new Reference();
        $formInsert = $this->createForm(new ReferenceType(), $reference);
        $formInsert->handleRequest($request);

        if ($formInsert->isValid()) {
            $sqlError = $this->newReference($reference);

            if ($sqlError)
                $formInsert->addError(new FormError($sqlError));
            else
                return $this->redirect($this->generateUrl('barra_back_references'));
        }

        $paginationRange = 10;
        $startPos = ($paginationActive-1)*$paginationRange;
        $em = $this->getDoctrine()->getManager();
        $references = $em->getRepository('BarraFrontBundle:Reference')->getSome($startPos, $paginationRange);
        $paginationCnt = $em->getRepository('BarraFrontBundle:Reference')->count();
        $paginationCnt = ceil($paginationCnt/$paginationRange);

        return $this->render('BarraBackBundle:Reference:references.html.twig', array(
                'paginationActive' => $paginationActive,
                'paginationCnt' => $paginationCnt,
                'references' => $references,
                'formInsert' => $formInsert->createView()
            ));
    }



    public function newReference($reference)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($reference);

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
        $id = $request->request->get('formReferenceUpdate')['id'];
        $reference = $em->getRepository('BarraFrontBundle:Reference')->find($id);

        if (!$reference) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        $formUpdate = $this->createForm(new ReferenceUpdateType(), $reference);
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



    public function deleteReferenceAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reference = $em->getRepository('BarraFrontBundle:Reference')->find($id);

        if (!$reference)
            throw $this->createNotFoundException('Reference not found');

        $em->remove($reference);
        $em->flush();

        return $this->redirect($this->generateUrl('barra_back_references'));
    }
}