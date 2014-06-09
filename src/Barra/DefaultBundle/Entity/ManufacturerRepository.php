<?php

namespace Barra\DefaultBundle\Entity;

use Doctrine\ORM\EntityRepository;


class ManufacturerRepository extends EntityRepository
{
    public function selectOneById($id) {
        $query = $this->getEntityManager()
            ->createQuery('SELECT m FROM BarraDefaultBundle:Manufacturer m WHERE m.id = :id')
            ->setParameter('id', $id);

        try {
            return $query->getSingleResult();
        } catch(\Doctrine\ORM\NoResultException $e) { // 0 resulsts
            return null;
        }
    }
}
