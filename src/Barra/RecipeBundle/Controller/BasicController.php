<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Entity\Repository\BasicRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BasicController extends Controller
{
    /** string */
    protected $entityClass;

    /**
     * @param int $range > 0
     *
     * @return float
     */
    protected function getPaginationPages($range = 10)
    {
        return ceil(10 / $range); // TODO mocked pagination
    }
}
