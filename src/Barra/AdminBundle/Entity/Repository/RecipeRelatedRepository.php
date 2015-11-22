<?php

namespace Barra\AdminBundle\Entity\Repository;

/**
 * Class RecipeRelatedRepository
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity\Repository
 */
class RecipeRelatedRepository extends BasicRepository
{
    /**
     * @param int $recipeId
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNextPosition($recipeId)
    {
        $query = $this
            ->createQueryBuilder('c')
            ->select('MAX(c.position)+1')
            ->where('c.recipe = :recipeId')
            ->setParameter('recipeId', $recipeId)
            ->getQuery()
        ;

        return $query->getSingleScalarResult();
    }
}
