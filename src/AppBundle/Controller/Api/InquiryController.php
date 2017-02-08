<?php

namespace AppBundle\Controller\Api;

use AppBundle\Form\InquiryType;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("is_authenticated()")
 */
class InquiryController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return View
     */
    public function newAction(): View
    {
        return $this->view($this->createForm(InquiryType::class));
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function postAction(Request $request): View
    {
        $form = $this->createForm(InquiryType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $inquire = $form->getData();
        $this->get('app.service.inquiry')->sendEmail($inquire);

        return $this->view(null, Response::HTTP_CREATED);
    }
}
