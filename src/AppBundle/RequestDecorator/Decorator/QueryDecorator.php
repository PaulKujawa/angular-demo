<?php

namespace AppBundle\RequestDecorator\Decorator;

use Doctrine\Common\Collections\Criteria;

interface QueryDecorator
{
    /**
     * @param Criteria $criteria
     */
    public function decorate(Criteria $criteria);
}
