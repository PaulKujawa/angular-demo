<?php

namespace Barra\RestBundle\Controller;

use Barra\BackBundle\Form\Type\CookingType;
use Barra\BackBundle\Entity\Cooking;
use Barra\BackBundle\Entity\Recipe;
use Barra\BackBundle\Entity\Repository\CookingRepository;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Annotations;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CookingController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class CookingController extends AbstractRestController
{
    public function newAction()
    {
        $form = $this->createForm(new CookingType(), new Cooking());

        return ['data' => $form];
    }


    protected function processForm(Request $request, $successCode, $entity = null)
    {
        if (null === $entity) {
            $entity = new Cooking();
        } elseif (!$entity instanceof Cooking) {
            throw new \InvalidArgumentException(sprintf('entity needs to be of type ' . $this->getEntityClass()));
        }

        $requestBody = array_values($request->request->all())[0];
        $recipe = $this->getRepo('Recipe')->find($requestBody['recipe']);
        $form = $this->createForm(new CookingType(), $entity, ['method' => $request->getMethod()]);
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
                ->setRecipe($recipe);
        };

        $duplicate = $this->getRepo()->find($entity->getId());
        if ($duplicate instanceof Cooking) {
            return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->persistEntity($request, $entity, $successCode);
    }
}
