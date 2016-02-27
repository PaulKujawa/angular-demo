<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Entity\Repository\BasicRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BasicController extends Controller
{
    /** @var EntityManager */
    protected $em;

    /** string */
    protected $entityClass;

    /**
     * @param int $range > 0
     *
     * @return float
     */
    protected function getPaginationPages($range = 10)
    {
        if (1 > $range) {
            throw new \InvalidArgumentException();
        }
        $repo = $this->getRepo();

        return ceil($repo->count() / $range);
    }

    /**
     * @return string
     */
    protected function getEntityClass()
    {
        if (null === $this->entityClass) {
            $className = get_class($this);
            $className = substr($className, strrpos($className, '\\') + 1, -10);
            $this->entityClass = ucfirst($className);
        }

        return $this->entityClass;
    }

    /**
     * @param string $entityClass
     *
     * @return BasicRepository
     */
    protected function getRepo($entityClass = null)
    {
        if (null === $entityClass) {
            $entityClass = $this->getEntityClass();
        }

        return $this->getEM()->getRepository('BarraRecipeBundle:' . ucfirst($entityClass));
    }

    /**
     * @return EntityManager
     */
    protected function getEM()
    {
        if (null === $this->em) {
            $this->em = $this->getDoctrine()->getManager();
        }

        return $this->em;
    }
}
