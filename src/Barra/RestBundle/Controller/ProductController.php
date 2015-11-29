<?php

namespace Barra\RestBundle\Controller;

use Barra\RecipeBundle\Entity\Product;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Util\Codes;

/**
 * Class ProductController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class ProductController extends RestController
{
    /**
     * @param int $id
     * @return View
     */
    public function getManufacturerAction($id)
    {
        $entity = $this->getRepo()->find($id);

        if (!$entity instanceof Product) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return $this->view(['data' => $entity->getManufacturer()]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function getIngredientsAction($id)
    {
        /** @var Product $entity */
        $entity = $this->getRepo()->find($id);

        if (null === $entity) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return $this->view(['data' => $entity->getIngredients()]);
    }
}
