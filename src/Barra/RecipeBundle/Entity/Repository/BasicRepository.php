<?php

namespace Barra\RecipeBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class BasicRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function count()
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $orderBy
     * @param string $order
     *
     * @return array
     */
    public function getSome($offset, $limit, $orderBy, $order = 'ASC')
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.' . $orderBy, $order)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
