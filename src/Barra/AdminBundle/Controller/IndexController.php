<?php

namespace Barra\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class IndexController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Controller
 */
class IndexController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function contactAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', 'text', [
                'attr'  => [
                    'placeholder' => 'admin.contact.name',
                ],
            ])
            ->add('email', 'email', [
                'attr' => [
                    'placeholder' => 'admin.contact.email',
                ],
            ])
            ->add('message', 'textarea', [
                'attr'  => [
                    'placeholder' => 'admin.contact.message',
                ],
            ])
            ->add('submit', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->sendMail($form->getData());
            $request
                ->getSession()
                ->getFlashBag()
                ->add('emailSent', $this->get('translator')->trans("admin.message.emailSent"));

            return $this->redirect($this->generateUrl('barra_admin_contact'));
        }

        return $this->render('BarraAdminBundle:Index:contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return Response
     */
    public function dashboardAction()
    {
        return $this->render('BarraAdminBundle:Index:dashboard.html.twig', []);
    }

    /**
     * @param array $enquiry
     */
    protected function sendMail(array $enquiry)
    {
        $mailer = $this->get("mailer");
        $mail   = $mailer->createMessage()
            ->setSubject("Portfolio enquiry from ". $enquiry["name"])
            ->setFrom($enquiry["email"])
            ->setTo("p.kujawa@gmx.net")
            ->setBody($enquiry["message"]);
        $mailer->send($mail);
    }
}
