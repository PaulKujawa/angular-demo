<?php

namespace Barra\RestBundle\Controller;

use Barra\AdminBundle\Form\Type\IngredientType;
use Barra\AdminBundle\Entity\Ingredient;
use Barra\AdminBundle\Entity\Recipe;
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

        if (!$recipe instanceof Recipe) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        if ($request->isMethod('POST')) {
            $position = $this->getRepo()->getNextPosition($recipe->getId());
            $entity
                ->setPosition($position)
                ->setRecipe($recipe)
            ;
        }

        if (!$form->isValid()) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        return $this->persistEntity($request, $entity, $successCode);
    }
}
