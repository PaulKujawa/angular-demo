<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RecipeRepository extends EntityRepository
{
    public function getSome($first, $amount)
    {
        $query = $this->createQueryBuilder('r')
            ->orderBy('r.name', 'ASC')
            ->setFirstResult($first)
            ->setMaxResults($amount)
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