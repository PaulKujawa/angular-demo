<?php

namespace Barra\FrontBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class AgencyRepository extends EntityRepository
{
    public function getSome($first, $amount)
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.name', 'ASC')
            ->setFirstResult($first)
            ->setMaxResults($amount)
            ->getQuery();

        return $query->getResult();
    }

    public function count()
    {
        $query = $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->getQuery();
        return $query->getSingleResult()[1];
    }
}