<?php

namespace Barra\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function indexAction(Request $request)
    {
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
            ->add('name', 'text')
            ->add('email', 'email')
            ->add('message', 'textarea')
            ->add('send', 'submit')
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