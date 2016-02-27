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
        if ($range < 1) {
            throw new \InvalidArgumentException();
        }

        $repoTitle = 'BarraRecipeBundle:' . ucfirst($this->getEntityClass());

        /** @var BasicRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository($repoTitle);

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
}
