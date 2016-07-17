<?php

namespace AppBundle\Controller;

use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @Route("/", name="app_contact")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sendMail($form->getData());
            $this->addFlash('success', $this->get('translator')->trans('barra.contact.email_sent'));

            return $this->redirectToRoute('app_contact');
        }

        return $this->render(':index:contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admino", name="app_dashboard")
     *
     * @return Response
     */
    public function dashboardAction()
    {
        return $this->render(':index:dashboard.html.twig');
    }

    /**
     * @param array $enquiry
     */
    protected function sendMail(array $enquiry)
    {
        $mailer = $this->get('mailer');
        $mail = $mailer->createMessage()
            ->setSubject('Portfolio enquiry from ' . $enquiry['name'])
            ->setFrom($enquiry['email'])
            ->setTo('p.kujawa@gmx.net')
            ->setBody($enquiry['message']);
        $mailer->send($mail);
    }
}
