<?php

namespace Barra\FrontBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CookingRepository extends EntityRepository
{
    public function changeBetweenPos($recipeId, $posBefore, $posAfter, $difference)
    {
        $query = $this->createQueryBuilder('c')
            ->update()
            ->set('c.position', 'c.position + :difference')
            ->where('c.recipe = :recipeId')
            ->andWhere('c.position BETWEEN :posBefore AND :posAfter')
            ->setParameter('posBefore', $posBefore)
            ->setParameter('posAfter', $posAfter)
            ->setParameter('recipeId', $recipeId)
            ->setParameter('difference', $difference)
            ->getQuery();

        return $query->getResult();
    }

    public function getHighestPosition($recipeId) {
        $query = $this->createQueryBuilder('c')
            ->select('MAX(c.position)')
            ->where('c.recipe = :recipeId')
            ->setParameter('recipeId', $recipeId)
            ->getQuery();

        return $query->getSingleResult()[1];
    }
}