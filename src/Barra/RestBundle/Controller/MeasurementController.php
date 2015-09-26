<?php

namespace Barra\RestBundle\Controller;

use Barra\BackBundle\Form\Type\MeasurementType;
use Barra\BackBundle\Entity\Measurement;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MeasurementController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class MeasurementController extends AbstractRestController
{
    public function newAction()
    {
        $form = $this->createForm(new MeasurementType(), new Measurement());
        return ['data' => $form];
    }


    protected function processForm(Request $request, $successCode, $entity = null)
    {
        if (null === $entity) {
            $entity = new Measurement();
        } elseif (!$entity instanceof Measurement) {
            throw new \InvalidArgumentException(sprintf('entity needs to be of type '.$this->getEntityClass()));
        }

        $form = $this->createForm(new MeasurementType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        $duplicate = $this->getRepo()->findOneByName($entity->getName());
        if ($duplicate instanceof Measurement) {
            return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->persistEntity($request, $entity, $successCode);
    }
}
