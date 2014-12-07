<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RecipeRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('name'=>'ASC'));
    }
}