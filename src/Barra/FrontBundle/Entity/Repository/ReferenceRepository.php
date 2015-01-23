<?php

namespace Barra\FrontBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ReferenceRepository extends EntityRepository
{
    public function getSome($first, $amount)
    {
        $query = $this->createQueryBuilder('r')
            ->orderBy('r.finished', 'DESC')
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