<?php

namespace Barra\RestBundle\Controller;

use Barra\AdminBundle\Form\Type\ProductType;
use Barra\AdminBundle\Entity\Product;
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

        return $this->persistEntity($request, $entity, $successCode);
    }
}
