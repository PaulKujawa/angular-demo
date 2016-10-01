<?php

namespace AppBundle\Controller;

use AppBundle\Form\InquiryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @Route("/", name="app_contact")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(InquiryType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render(':index:contact.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $inquire = $form->getData();
        $this->get('app.inquiry')->sendEmail($inquire);
        $this->addFlash('success', $this->get('translator')->trans('barra.contact.email_sent'));

        return $this->redirectToRoute('app_contact');
    }

    /**
     * @Security("is_authenticated()")
     *
     * @Route("/admino", name="app_dashboard")
     *
     * @return Response
     */
    public function dashboardAction()
    {
        return $this->render(':index:dashboard.html.twig');
    }
}
