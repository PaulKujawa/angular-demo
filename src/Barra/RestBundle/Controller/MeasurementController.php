<?php

namespace Barra\RestBundle\Controller;

use Barra\RecipeBundle\Entity\Measurement;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Util\Codes;

/**
 * Class MeasurementController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class MeasurementController extends RestController
{
    /**
     * @param int $id
     * @return View
     */
    public function getIngredientsAction($id)
    {
        /** @var Measurement $entity */
        $entity = $this->getRepo()->find($id);

        if (null === $entity) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return $this->view(['data' => $entity->getIngredients()]);
    }
}
