<?php

namespace Barra\FrontBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ManufacturerRepository extends EntityRepository
{
    public function getSome($first, $amount)
    {
        $query = $this->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC')
            ->setFirstResult($first)
            ->setMaxResults($amount)
            ->getQuery();

        return $query->getResult();
    }

    public function count()
    {
        $query = $this->createQueryBuilder('m')
            ->select('COUNT(m)')
            ->getQuery();
        return $query->getSingleResult()[1];
    }
}