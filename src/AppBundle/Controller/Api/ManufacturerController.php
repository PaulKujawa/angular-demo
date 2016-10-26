<?php

namespace AppBundle\Controller\Api;

use AppBundle\Form\ManufacturerType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\GreaterThan;

class ManufacturerController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return View
     */
    public function newAction()
    {
        return $this->view($this->createForm(ManufacturerType::class));
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getProductsAction($id)
    {
        $manufacturer = $this->get('app.repository.manufacturer')->getManufacturer($id);

        return null === $manufacturer
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($manufacturer->getProducts());
    }

    /**
     * @QueryParam(name="page", requirements=@GreaterThan(value=0), default="1")
     *
     * @param int $page
     *
     * @return View
     */
    public function cgetAction($page)
    {
        return $this->get('app.repository.manufacturer')->getManufacturers($page);
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getAction($id)
    {
        $manufacturer = $this->get('app.repository.manufacturer')->getManufacturer($id);

        return null === $manufacturer
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($manufacturer);
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(ManufacturerType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $manufacturer = $this->get('app.repository.manufacturer')->addManufacturer($form->getData());

        return $this->routeRedirectView(
            'api_get_manufacturer',
            ['id' => $manufacturer->getId()],
            Response::HTTP_CREATED
        );
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return View
     */
    public function putAction(Request $request, $id)
    {
        $manufacturer = $this->get('app.repository.manufacturer')->getManufacturer($id);

        if (null === $manufacturer) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ManufacturerType::class, $manufacturer, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.repository.manufacturer')->setManufacturer($manufacturer);

        return $this->routeRedirectView(
            'api_get_manufacturer',
            ['id' => $manufacturer->getId()],
            Response::HTTP_NO_CONTENT
        );
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function deleteAction($id)
    {
        $manufacturer = $this->get('app.repository.manufacturer')->getManufacturer($id);

        if (null === $manufacturer) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->get('app.repository.manufacturer')->deleteManufacturer($manufacturer);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
