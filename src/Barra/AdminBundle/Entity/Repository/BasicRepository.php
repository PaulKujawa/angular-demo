<?php

namespace Barra\AdminBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class BasicRepository
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity\Repository
 */
class BasicRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function count()
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    /**
     * @param int       $offset
     * @param int       $limit
     * @param string    $orderBy
     * @param string    $order
     * @return array
     */
    public function getSome($offset, $limit, $orderBy, $order)
    {
        $query = $this
            ->createQueryBuilder('m')
            ->orderBy('m.'.$orderBy, $order)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }
}
