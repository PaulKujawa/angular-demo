<?php

namespace AppBundle\RequestDecorator\Decorator;

use Doctrine\Common\Collections\Criteria;

interface QueryDecorator
{
    public function decorate(Criteria $criteria): void;
}
