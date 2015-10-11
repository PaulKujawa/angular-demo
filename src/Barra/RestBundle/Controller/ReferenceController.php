<?php

namespace Barra\RestBundle\Controller;

use Barra\AdminBundle\Form\Type\ReferenceType;
use Barra\AdminBundle\Entity\Reference;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReferenceController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class ReferenceController extends AbstractRestController
{
    public function newAction()
    {
        $form = $this->createForm(new ReferenceType(), new Reference());
        return ['data' => $form];
    }


    protected function processForm(Request $request, $successCode, $entity = null)
    {
        if (null === $entity) {
            $entity = new Reference();
        } elseif (!$entity instanceof Reference) {
            throw new \InvalidArgumentException(sprintf('entity needs to be of type '.$this->getEntityClass()));
        }

        $form = $this->createForm(new ReferenceType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        if ($request->isMethod('POST')) {
//           TODO $entity->setFile()
        }

        return $this->persistEntity($request, $entity, $successCode);
    }
}
