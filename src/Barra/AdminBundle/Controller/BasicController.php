<?php

namespace Barra\AdminBundle\Controller;

use Barra\AdminBundle\Entity\Repository\PaginationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class BasicController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Controller
 */
class BasicController extends Controller
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    /** string */
    protected $entityClass;


    /**
     * @param null|int $range value bigger than 0
     * @return float
     */
    protected function getPaginationPages($range = 10)
    {
        if ($range < 1) {
            throw new \InvalidArgumentException();
        }

        $repo = $this->getRepo();
        if (!$repo instanceof PaginationRepository) {
            throw new \RuntimeException();
        }

        return ceil($repo->count() / $range);
    }


    /**
     * @return string upper cased semantic name of inheriting controller
     */
    protected function getEntityClass()
    {
        if (null === $this->entityClass) {
            $className = get_class($this);
            $this->entityClass = ucfirst(
                substr(
                    $className,
                    strrpos($className, '\\') + 1,
                    -10
                )
            );
        }

        return $this->entityClass;
    }


    /**
     * @param string $entityClass
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepo($entityClass = null)
    {
        if (null === $entityClass) {
            $entityClass = $this->getEntityClass();
        }

        return $this->getEM()->getRepository('BarraAdminBundle:'.ucfirst($entityClass));
    }


    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEM()
    {
        if (null === $this->em) {
            $this->em = $this->getDoctrine()->getManager();
        }

        return $this->em;
    }
}
