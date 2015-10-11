<?php

namespace Barra\RestBundle\Controller;

use Barra\AdminBundle\Form\Type\TechniqueType;
use Barra\AdminBundle\Entity\Technique;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TechniqueController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class TechniqueController extends AbstractRestController
{
    public function newAction()
    {
        $form = $this->createForm(new TechniqueType(), new Technique());
        return ['data' => $form];
    }


    protected function processForm(Request $request, $successCode, $entity = null)
    {
        if (null === $entity) {
            $entity = new Technique();
        } elseif (!$entity instanceof Technique) {
            throw new \InvalidArgumentException(sprintf('entity needs to be of type '.$this->getEntityClass()));
        }

        $form = $this->createForm(new TechniqueType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        return $this->persistEntity($request, $entity, $successCode);
    }
}
