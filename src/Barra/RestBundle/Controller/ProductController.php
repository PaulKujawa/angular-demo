<?php

namespace Barra\RestBundle\Controller;

use Barra\BackBundle\Form\Type\ProductType;
use Barra\BackBundle\Entity\Product;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProductController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class ProductController extends AbstractRestController
{
    public function newAction()
    {
        $form = $this->createForm(new ProductType(), new Product());
        return ['data' => $form];
    }


    protected function processForm(Request $request, $successCode, $entity = null)
    {
        if (null === $entity) {
            $entity = new Product();
        } elseif (!$entity instanceof Product) {
            throw new \InvalidArgumentException(sprintf('entity needs to be of type '.$this->getEntityClass()));
        }

        $form = $this->createForm(new ProductType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        $duplicate = $this->getRepo()->findOneByName($entity->getName());
        if ($duplicate instanceof Product) {
            return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->persistEntity($request, $entity, $successCode);
    }
}
