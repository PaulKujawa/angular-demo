<?php

namespace Barra\FrontBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class TechniqueRepository extends EntityRepository
{
    public function getSome($first, $amount)
    {
        $query = $this->createQueryBuilder('t')
            ->orderBy('t.name', 'ASC')
            ->setFirstResult($first)
            ->setMaxResults($amount)
            ->getQuery();

        return $query->getResult();
    }

    public function count()
    {
        $query = $this->createQueryBuilder('t')
            ->select('COUNT(t)')
            ->getQuery();
        return $query->getSingleResult()[1];
    }
}