<?php

namespace Barra\FrontBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class IngredientRepository
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity\Repository
 */
class IngredientRepository extends EntityRepository
{
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
            ->createQueryBuilder('i')
            ->where('i.recipe = :recipeId')
            ->orderBy('i.'.$orderBy, $order)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('recipeId', $recipeId)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param int $recipeId
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNextPosition($recipeId) {
        $query = $this
            ->createQueryBuilder('i')
            ->select('MAX(i.position)+1')
            ->where('i.recipe = :recipeId')
            ->setParameter('recipeId', $recipeId)
            ->getQuery();

        return $query->getSingleResult()[1];
    }
}