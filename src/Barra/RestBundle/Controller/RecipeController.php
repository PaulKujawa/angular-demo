<?php

namespace Barra\RestBundle\Controller;

use Barra\RecipeBundle\Entity\Recipe;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Util\Codes;

/**
 * Class RecipeController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class RecipeController extends RestController
{
    /**
     * @param int $id
     * @return View
     */
    public function getIngredientsAction($id)
    {
        /** @var Recipe $entity */
        $entity = $this->getRepo()->find($id);

        if (null === $entity) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return $this->view(['data' => $entity->getIngredients()]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function getCookingsAction($id)
    {
        /** @var Recipe $entity */
        $entity = $this->getRepo()->find($id);

        if (null === $entity) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return $this->view(['data' => $entity->getCookings()]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function getPhotosAction($id)
    {
        /** @var Recipe $entity */
        $entity = $this->getRepo()->find($id);

        if (null === $entity) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return $this->view(['data' => $entity->getPhotos()]);
    }
}
