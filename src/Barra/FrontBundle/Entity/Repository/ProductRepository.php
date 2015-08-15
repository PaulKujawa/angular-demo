<?php

namespace Barra\FrontBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ProductRepository
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity\Repository
 */
class ProductRepository extends EntityRepository
{
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
            ->createQueryBuilder('p')
            ->orderBy('p.'.$orderBy, $order)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @return int
     */
    public function count()
    {
        $query = $this
            ->createQueryBuilder('r')
            ->select('COUNT(r)')
            ->getQuery()
        ;

        return $query->getSingleScalarResult();
    }
}