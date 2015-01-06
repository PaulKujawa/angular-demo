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
    public function indexAction(Request $request)
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

        $em = $this->getDoctrine()->getManager();
        $references = $em->getRepository('BarraFrontBundle:Reference')->findAll();

        return $this->render('BarraBackBundle:Reference:references.html.twig', array(
                'references' => $references,
                'formInsert' => $formInsert->createView()
            ));
    }

    public function newReference($reference)
    {
        /*$em = $this->getDoctrine()->getManager();
        $em->persist($reference);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return $this->get('translator')->trans("back.message.insertError");
        }
        return null;*/
    }

    public function deleteReferenceAction($website)
    {
       /* $em = $this->getDoctrine()->getManager();
        $reference = $em->getRepository('BarraFrontBundle:Reference')->findOneByWebsite($website);

        if (!$reference)
            throw $this->createNotFoundException('Reference not found');
        $em->remove($reference);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Reference could not be deleted');
        }

        return $this->redirect($this->generateUrl('barra_back_references'));*/
    }
}