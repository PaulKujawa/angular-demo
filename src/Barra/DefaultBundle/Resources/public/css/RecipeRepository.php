<?php

namespace Barra\DefaultBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RecipeRepository extends EntityRepository
{
    public function selectAllOrderedByTitel()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT r FROM BarraDefaultBundle:Recipe r ORDER BY r.titel ASC')
            ->getResult();
    }


    public function selectRecipeById($id)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT r FROM BarraDefaultBundle:Recipe r WHERE r.id = :id')
            ->setParameter('id', $id)
            ->getOneOrNullResult();
    }
}
