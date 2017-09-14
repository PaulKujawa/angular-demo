<?php

namespace AppBundle\Controller\Api;

use AppBundle\Form\InquiryType;
use AppBundle\Service\InquiryService;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InquiryController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @var InquiryService
     */
    private $inquiryService;

    public function __construct(InquiryService $inquiryService)
    {
        $this->inquiryService = $inquiryService;
    }

    public function newAction(): View
    {
        return $this->view($this->createForm(InquiryType::class));
    }

    public function postAction(Request $request): View
    {
        $form = $this->createForm(InquiryType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $inquire = $form->getData();
        $this->inquiryService->sendEmail($inquire);

        return $this->view(null, Response::HTTP_CREATED);
    }
}
