<?php

namespace Barra\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ContactController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Controller
 */
class ContactController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', 'text', [
                'attr'  => [
                    'placeholder' => 'front.contact.name',
                ],
            ])
            ->add('email', 'email', [
                'attr' => [
                    'placeholder' => 'front.contact.email',
                ],
            ])
            ->add('message', 'textarea', [
                'attr'  => [
                    'placeholder' => 'front.contact.message',
                ],
            ])
            ->add('submit', 'submit')
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->sendMail($form->getData());
            $request
                ->getSession()
                ->getFlashBag()
                ->add('emailSent', $this->get('translator')->trans("front.message.emailSent"))
            ;

            return $this->redirect($this->generateUrl('barra_front_contact'));
        }

        return $this->render('BarraFrontBundle:Contact:contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * Sends the contact mail to p.kujawa@gmx.net
     * @param $enquiry
     */
    private function sendMail($enquiry)
    {
        $mailer = $this->get("mailer");
        $mail = $mailer->createMessage()
            ->setSubject("Portfolio enquiry from ". $enquiry["name"])
            ->setFrom($enquiry["email"])
            ->setTo("p.kujawa@gmx.net")
            ->setBody($enquiry["message"])
        ;
        $mailer->send($mail);
    }
}
