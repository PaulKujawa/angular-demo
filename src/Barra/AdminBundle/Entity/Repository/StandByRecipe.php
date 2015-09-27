<?php

namespace Barra\AdminBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class BasicByRecipe
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity\Repository
 */
class StandByRecipe extends EntityRepository
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


    /**
     * @param int       $recipeId
     * @param int       $offset
     * @param int       $limit
     * @param string    $orderBy
     * @param string    $order
     * @return array
     */
    public function getSome($recipeId, $offset, $limit, $orderBy, $order)
    {
        $query = $this
            ->createQueryBuilder('c')
            ->where('c.recipe = :recipeId')
            ->orderBy('c.'.$orderBy, $order)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('recipeId', $recipeId)
            ->getQuery()
        ;

        return $query->getResult();
    }
}
