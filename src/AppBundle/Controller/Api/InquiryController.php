<?php

namespace AppBundle\Controller\Api;

use AppBundle\Form\InquiryType;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InquiryController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return View
     */
    public function newAction()
    {
        return $this->view($this->createForm(InquiryType::class));
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(InquiryType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $inquire = $form->getData();
        $this->get('app.repository.inquiry')->sendEmail($inquire);

        return $this->view(null, Response::HTTP_CREATED);
    }
}
