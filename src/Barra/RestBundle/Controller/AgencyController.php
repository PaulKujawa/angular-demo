<?php

namespace Barra\RestBundle\Controller;

use Barra\AdminBundle\Form\Type\AgencyType;
use Barra\AdminBundle\Entity\Agency;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AgencyController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class AgencyController extends AbstractRestController
{
    public function newAction() {
        $form = $this->createForm(new AgencyType(), new Agency());
        return ['data' => $form];
    }


    protected function processForm(Request $request, $successCode, $entity = null)
    {
        if (null === $entity) {
            $entity = new Agency();
        } elseif (!$entity instanceof Agency) {
            throw new \InvalidArgumentException(sprintf('entity needs to be of type '.$this->getEntityClass()));
        }

        $form = $this->createForm(new AgencyType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        $duplicate = $this->getRepo()->findOneByName($entity->getName());
        if ($duplicate instanceof Agency) {
            return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->persistEntity($request, $entity, $successCode);
    }
}
