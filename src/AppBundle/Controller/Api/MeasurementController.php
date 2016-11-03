<?php

namespace AppBundle\Controller\Api;

use AppBundle\Form\MeasurementType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\GreaterThan;

class MeasurementController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return View
     */
    public function newAction()
    {
        return $this->view($this->createForm(MeasurementType::class));
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
        return $this->get('app.repository.measurement')->getMeasurements($page);
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getAction($id)
    {
        $measurement = $this->get('app.repository.measurement')->getMeasurement($id);

        return null === $measurement
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($measurement->get);
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(MeasurementType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $measurement = $this->get('app.repository.measurement')->addMeasurement($form->getData());
        
        return $this->routeRedirectView(
            'api_get_measurement',
            ['id' => $measurement->getId()],
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
        $measurement = $this->get('app.repository.measurement')->getMeasurement($id);

        if (null === $measurement) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(MeasurementType::class, $measurement, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.repository.measurement')->setMeasurement($measurement);

        return $this->routeRedirectView(
            'api_get_measurement',
            ['id' => $id],
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
        $measurement = $this->get('app.repository.measurement')->getMeasurement($id);

        if (null === $measurement) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->get('app.repository.measurement')->deleteMeasurement($measurement);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
