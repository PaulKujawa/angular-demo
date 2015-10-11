<?php

namespace Barra\RestBundle\Controller;

use Barra\AdminBundle\Form\Type\RecipeType;
use Barra\AdminBundle\Entity\Recipe;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RecipeController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class RecipeController extends AbstractRestController
{
    public function newAction()
    {
        $form = $this->createForm(new RecipeType(), new Recipe());
        return ['data' => $form];
    }


    protected function processForm(Request $request, $successCode, $entity = null)
    {
        if (null === $entity) {
            $entity = new Recipe();
        } elseif (!$entity instanceof Recipe) {
            throw new \InvalidArgumentException(sprintf('entity needs to be of type '.$this->getEntityClass()));
        }

        $form = $this->createForm(new RecipeType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        return $this->persistEntity($request, $entity, $successCode);
    }
}
