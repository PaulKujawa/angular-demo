<?php

namespace Barra\FrontBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class RecipeRepository extends EntityRepository
{
    public function getSome($offset, $limit, $orderBy, $order)
    {
        $query = $this->createQueryBuilder('r')
            ->orderBy('r.'.$orderBy, $order)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }

    public function count()
    {
        $query = $this->createQueryBuilder('r')
            ->select('COUNT(r)')
            ->getQuery();
        return $query->getSingleResult()[1];
    }
}