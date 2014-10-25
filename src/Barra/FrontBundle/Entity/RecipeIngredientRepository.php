<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RecipeIngredientRepository extends EntityRepository
{
    public function changeBetweenPos($recipeId, $posBefore, $posAfter, $difference)
    {
        $query = $this->createQueryBuilder('ri')
            ->update()
            ->set('ri.position', 'ri.position + :difference')
            ->where('ri.recipe = :recipeId')
            ->andWhere('ri.position BETWEEN :posBefore AND :posAfter')
            ->setParameter('posBefore', $posBefore)
            ->setParameter('posAfter', $posAfter)
            ->setParameter('recipeId', $recipeId)
            ->setParameter('difference', $difference)
            ->getQuery();

        return $query->getResult();
    }

    public function getNextPosition($recipeId) {
        $query = $this->createQueryBuilder('ri')
            ->select('MAX(ri.position)+1')
            ->where('ri.recipe = :recipeId')
            ->setParameter('recipeId', $recipeId)
            ->getQuery();

        return $query->getSingleResult()[1];
    }
}