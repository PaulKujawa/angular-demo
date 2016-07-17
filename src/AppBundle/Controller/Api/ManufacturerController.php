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
        $manufacturer = $this->get('app.manufacturer')->getManufacturer($id);

        return null === $manufacturer
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($manufacturer->getProducts());
    }

    /**
     * @QueryParam(name="offset", requirements="\d+", default="0")
     * @QueryParam(name="limit", requirements="[1-9]\d*", default="10")
     * @QueryParam(name="orderBy", requirements="\w+", default="id")
     * @QueryParam(name="order", requirements="(asc|desc)", default="asc")
     *
     * @param string $offset
     * @param string $limit
     * @param string $orderBy
     * @param string $order
     *
     * @return View
     */
    public function cgetAction($offset, $limit, $orderBy, $order)
    {
        $manufacturers = $this->get('app.manufacturer')->getManufacturers($orderBy, $order, $limit, $offset);

        return $this->view($manufacturers);
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getAction($id)
    {
        $manufacturer = $this->get('app.manufacturer')->getManufacturer($id);

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

        $manufacturer = $this->get('app.manufacturer')->addManufacturer($form->getData());

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
        $manufacturer = $this->get('app.manufacturer')->getManufacturer($id);

        if (null === $manufacturer) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ManufacturerType::class, $manufacturer, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.manufacturer')->setManufacturer($manufacturer);

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
        $manufacturer = $this->get('app.manufacturer')->getManufacturer($id);

        if (null === $manufacturer) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->get('app.manufacturer')->deleteManufacturer($manufacturer);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
