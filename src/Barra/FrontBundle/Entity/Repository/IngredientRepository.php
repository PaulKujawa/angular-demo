<?php

namespace Barra\FrontBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class IngredientRepository extends EntityRepository
{
    public function getSome($first, $amount)
    {
        $query = $this->createQueryBuilder('i')
            ->orderBy('i.name', 'ASC')
            ->setFirstResult($first)
            ->setMaxResults($amount)
            ->getQuery();

        return $query->getResult();
    }

    public function count()
    {
        $query = $this->createQueryBuilder('i')
            ->select('COUNT(i)')
            ->getQuery();
        return $query->getSingleResult()[1];
    }
}