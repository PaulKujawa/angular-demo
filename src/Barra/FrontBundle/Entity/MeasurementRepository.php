<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\EntityRepository;

class MeasurementRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('type'=>'ASC'));
    }
}