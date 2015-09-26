<?php

namespace Barra\RestBundle\Controller;

use Barra\BackBundle\Form\Type\IngredientType;
use Barra\BackBundle\Entity\Ingredient;
use Barra\BackBundle\Entity\Recipe;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IngredientController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class IngredientController extends AbstractRestController
{
    public function newAction()
    {
        $form = $this->createForm(new IngredientType(), new Ingredient());
        return ['data' => $form];
    }


    protected function processForm(Request $request, $successCode, $entity = null)
    {
        if (null === $entity) {
            $entity = new Ingredient();
        } elseif (!$entity instanceof Ingredient) {
            throw new \InvalidArgumentException(sprintf('entity needs to be of type '.$this->getEntityClass()));
        }

        $requestBody = array_values($request->request->all())[0];
        $recipe      = $this->getRepo('Recipe')->find($requestBody['recipe']);
        $form        = $this->createForm(new IngredientType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid() ||
            !$recipe instanceof Recipe
        ) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        if ($request->isMethod('POST')) {
            $position = $this->getRepo()->getNextPosition($recipe->getId());
            $entity
                ->setPosition($position)
                ->setRecipe($recipe)
            ;
        }

        $duplicate = $this->getRepo()->find($entity->getId());
        if ($duplicate instanceof Ingredient) {
            return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->persistEntity($request, $entity, $successCode);
    }
}
