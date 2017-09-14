<?php

namespace AppBundle\Controller\Api;

use AppBundle\Form\MeasurementType;
use AppBundle\Repository\MeasurementRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\GreaterThan;

/**
 * @Security("is_authenticated()")
 */
class MeasurementController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @var MeasurementRepository
     */
    private $measurementRepository;

    public function __construct(MeasurementRepository $measurementRepository)
    {
        $this->measurementRepository = $measurementRepository;
    }

    public function newAction(): View
    {
        return $this->view($this->createForm(MeasurementType::class));
    }

    /**
     * @QueryParam(name="page", requirements=@GreaterThan(value=0), default="1")
     */
    public function cgetAction(int $page): View
    {
        $measurements = $this->measurementRepository->getMeasurements($page);

        return $this->view($measurements);
    }

    public function getAction(int $id): View
    {
        $measurement = $this->measurementRepository->getMeasurement($id);

        return null === $measurement
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($measurement->get);
    }

    public function postAction(Request $request): View
    {
        $form = $this->createForm(MeasurementType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $measurement = $this->measurementRepository->addMeasurement($form->getData());

        return $this->routeRedirectView('api_get_measurement', ['id' => $measurement->id], Response::HTTP_CREATED);
    }

    public function putAction(Request $request, int $id): View
    {
        $measurement = $this->measurementRepository->getMeasurement($id);

        if (null === $measurement) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(MeasurementType::class, $measurement, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->measurementRepository->setMeasurement($measurement);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteAction(int $id): View
    {
        $measurement = $this->measurementRepository->getMeasurement($id);

        if (null === $measurement) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->measurementRepository->deleteMeasurement($measurement);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
