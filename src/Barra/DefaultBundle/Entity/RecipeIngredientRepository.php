<?php

namespace Barra\DefaultBundle\Entity;

use Doctrine\ORM\EntityRepository;


class RecipeIngredientRepository extends EntityRepository
{
    public function findMaxId()
    {
        $query = $this->createQueryBuilder('ri')
            ->select('MAX(ri.id)')
            ->getQuery();

        $recipes = $query->getSingleResult();

        if ($recipes[1] == null)
            return 0;

        return $recipes[1];
    }
}

