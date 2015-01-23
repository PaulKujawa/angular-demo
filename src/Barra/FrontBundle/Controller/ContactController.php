<?php

namespace Barra\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', 'text', array(
                'attr'=>array('placeholder'=>'front.contact.name')
                ))
            ->add('email', 'email', array(
                    'attr'=>array('placeholder'=>'front.contact.email')
                ))
            ->add('message', 'textarea', array(
                    'attr'=>array('placeholder'=>'front.contact.message')
                ))
            ->add('submit', 'submit')
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->sendMail($form->getData());
            return $this->redirect($this->generateUrl('barra_front_contact'));
        }

        return $this->render('BarraFrontBundle:Contact:contact.html.twig', array (
                'form' => $form->createView(),
            ));
    }



    private function sendMail($enquiry)
    {
        $mailer = $this->get("mailer");
        $mail = $mailer->createMessage()
            ->setSubject("Portfolio enquiry from ". $enquiry["name"])
            ->setFrom($enquiry["email"])
            ->setTo("p.kujawa@gmx.net")
            ->setBody($enquiry["message"]);
        $mailer->send($mail);
    }
}