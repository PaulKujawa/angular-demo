<?php

namespace Barra\RecipeBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class RecipeRelatedRepository extends EntityRepository
{
    /**
     * @param int $recipeId
     *
     * @return int
     */
    public function getNextPosition($recipeId)
    {
        return $this
            ->createQueryBuilder('c')
            ->select('MAX(c.position)+1')
            ->where('c.recipe = :recipeId')
            ->setParameter('recipeId', $recipeId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
