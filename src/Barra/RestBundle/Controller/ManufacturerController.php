<?php

namespace Barra\RestBundle\Controller;

use Barra\AdminBundle\Entity\Manufacturer;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Util\Codes;

/**
 * Class ManufacturerController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class ManufacturerController extends RestController
{
    /**
     * @param int $id
     * @return View
     */
    public function getProductsAction($id)
    {
        /** @var Manufacturer $entity */
        $entity = $this->getRepo()->find($id);

        if (null === $entity) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return $this->view(['data' => $entity->getProducts()]);
    }
}
