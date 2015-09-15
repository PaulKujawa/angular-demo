<?php

namespace Barra\FrontBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class StandAlone
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity\Repository
 */
class StandAlone extends EntityRepository
{
    /**
     * @return int
     */
    public function count()
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->getQuery()
        ;

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
            ->getQuery()
        ;

        return $query->getResult();
    }
}
