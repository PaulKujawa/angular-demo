<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\ReferencePicture;
use Barra\BackBundle\Form\Type\ReferencePictureType;

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
        $formReferencePicture = $this->createForm(new ReferencePictureType(), $referencePicture);

        $formReferencePicture->get('reference')->setData($reference->getId());

        return $this->render('BarraBackBundle:Reference:referencePictures.html.twig', array(
                'reference'             => $reference,
                'formReferencePicture'  => $formReferencePicture->createView(),
            ));
    }



    public function uploadPictureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $referenceId = $request->request->get('formReferencePicture')['reference'];
        $reference = $em->getRepository('BarraFrontBundle:Reference')->find($referenceId);

        if (!$reference)
            throw $this->createNotFoundException('Reference not found');

        foreach($request->files as $file) { // not necessary, since dropzone sends for every file an own request which depends on current config
            $recipeFile = new ReferencePicture();

            $form = $this->createForm(new ReferencePictureType(), $recipeFile);
            $form->handleRequest($request);
            $recipeFile->setReference($reference);
            $recipeFile->setSize($file->getClientSize());
            $recipeFile->setFile($file);

            if ($form->isValid()) {
           //     return new Response(json_encode("yoo"), 200, array('Content-Type'=>'application/json'));
                $em->persist($recipeFile);
                $em->flush();

                $id = $recipeFile->getId();
                $ajaxResponse = array("code"=>404, "id"=>$id);
            } else {
                $validationError = $this->get('barra_back.formValidation')->getErrorMessages($form);
                $ajaxResponse = array("code"=>400, "message"=>$validationError);
            }
        }
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    public function getPicturesAction($referenceId)
    {
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('BarraFrontBundle:ReferencePicture')->findByReference($referenceId);

        $container = array();
        for ($i=0; $i < count($files); $i++) {
            $container[$i]['id']        = $files[$i]->getId();
            $container[$i]['filename']  = $files[$i]->getFilename();
            $container[$i]['size']      = $files[$i]->getSize();
        }

        $ajaxResponse = array("code"=>200, "files"=>$container);
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    public function deletePictureAction($referenceId, $id)
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
