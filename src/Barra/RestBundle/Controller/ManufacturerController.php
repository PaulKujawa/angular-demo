<?php

namespace Barra\RestBundle\Controller;

use Barra\AdminBundle\Form\Type\ManufacturerType;
use Barra\AdminBundle\Entity\Manufacturer;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ManufacturerController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class ManufacturerController extends AbstractRestController
{
    public function newAction()
    {
        $form = $this->createForm(new ManufacturerType(), new Manufacturer());
        return ['data' => $form];
    }


    protected function processForm(Request $request, $successCode, $entity = null)
    {
        if (null === $entity) {
            $entity = new Manufacturer();
        } elseif (!$entity instanceof Manufacturer) {
            throw new \InvalidArgumentException(sprintf('entity needs to be of type '.$this->getEntityClass()));
        }

        $form = $this->createForm(new ManufacturerType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        return $this->persistEntity($request, $entity, $successCode);
    }
}
