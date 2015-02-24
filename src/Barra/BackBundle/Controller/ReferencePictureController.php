<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Reference;
use Barra\FrontBundle\Entity\ReferencePicture;
use Barra\BackBundle\Form\Type\ReferencePictureType;
use Barra\BackBundle\Form\Type\Update\ReferenceUpdateType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReferencePictureController extends Controller
{
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reference = $em->getRepository('BarraFrontBundle:Reference')->find($id);
        if (!$reference)
            throw $this->createNotFoundException('Reference not found');


        $referencePicture  = new ReferencePicture();
        $formReferenceLogo    = $this->createForm(new ReferencePictureType(), $referencePicture);
        $formReferencePicture = $this->createForm(new ReferencePictureType(), $referencePicture);

        $formReferencePicture->get('reference')->setData($reference->getId());

        return $this->render('BarraBackBundle:Reference:referencePictures.html.twig', array(
                'reference'             => $reference,
                'formReferenceLogo'     => $formReferenceLogo->createView(),
                'formReferencePicture'  => $formReferencePicture->createView(),
            ));
    }



    /**
     * Add logo to existing reference db entry
     * @param Request $request
     * @return Response
     */
    public function uploadAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $referenceId = $request->request->get('formReferencePicture')['reference'];
        $reference = $em->getRepository('BarraFrontBundle:Reference')->find($referenceId);

        if (!$reference)
            throw $this->createNotFoundException('Reference not found');

        foreach($request->files as $file) { // not necessary, since dropzone sends for every file an own request which depends on current config
            $referencePicture = new ReferencePicture();

            $form = $this->createForm(new ReferencePictureType(), $referencePicture);
            $form->handleRequest($request);
            $referencePicture->setReference($reference);
            $referencePicture->setSize($file->getClientSize());
            $referencePicture->setFile($file);

            if ($form->isValid()) {
                $em->persist($referencePicture);
                $em->flush();

                $id = $referencePicture->getId();
                $ajaxResponse = array("code"=>404, "id"=>$id);
            } else {
                $validationError = $this->get('barra_back.formValidation')->getErrorMessages($form);
                $ajaxResponse = array("code"=>400, "message"=>$validationError);
            }
        }
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    /** Updates logo, doesn't check if valid form though
     * @param Request $request
     * @return Response
     */
    public function updateLogoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('formReferenceLogo')['reference'];
        $reference = $em->getRepository('BarraFrontBundle:Reference')->find($id);

        if (!$reference) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        foreach($request->files as $file) { // not necessary, since dropzone sends for every file an own request which depends on current config
            $reference->setSize($file->getClientSize());
            $reference->setFile($file);
            $reference->setFilename($file->getClientOriginalName());

            try {
                $em->flush();
                $ajaxResponse = array("code"=>200, "message"=>"ok");
            } catch (\Doctrine\DBAL\DBALException $e) {
                $validationErrors = $this->get('translator')->trans("back.message.insertError");
                $ajaxResponse = array("code"=>409, "dbError"=>$validationErrors);
            }
        }
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }


    /** Returns logo image
     * @param $referenceId
     * @return Response
     */
    public function getLogoAction($referenceId)
    {
        $em = $this->getDoctrine()->getManager();
        $logo = $em->getRepository('BarraFrontBundle:Reference')->find($referenceId);

        $container = array();
        if (sizeof($logo) == 2) { // 1 == empty
            $container[0]['id']        = $logo->getId();
            $container[0]['title']     = $logo->getTitle();
            $container[0]['filename']  = $logo->getFilename();
            $container[0]['size']      = $logo->getSize();
        }

        $ajaxResponse = array("code"=>200, "files"=>$container);
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    public function getAction($referenceId)
    {
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('BarraFrontBundle:ReferencePicture')->findByReference($referenceId);

        $container = array();
        for ($i=0; $i < count($files); $i++) {
            $container[$i]['id']        = $files[$i]->getId();
            $container[$i]['title']     = $files[$i]->getTitle();
            $container[$i]['filename']  = $files[$i]->getFilename();
            $container[$i]['size']      = $files[$i]->getSize();
        }

        $ajaxResponse = array("code"=>200, "files"=>$container);
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    public function deleteAction($referenceId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('BarraFrontBundle:ReferencePicture')->find($id);

        if (!$file)
            throw $this->createNotFoundException('File not found');

        $em->remove($file);
        $em->flush();

        return $this->redirect($this->generateUrl('barra_back_reference_pictures', array('id'=>$referenceId)));
    }
}
