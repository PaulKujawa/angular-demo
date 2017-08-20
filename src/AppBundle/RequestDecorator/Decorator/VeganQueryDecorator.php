<?php

namespace AppBundle\RequestDecorator\Decorator;

use Doctrine\Common\Collections\Criteria;

class VeganQueryDecorator implements QueryDecorator
{
    /**
     * @var bool
     */
    private $isVegan;

    public function __construct(bool $isVegan)
    {
        $this->isVegan = $isVegan;
    }

    public function decorate(Criteria $criteria): void
    {
        $criteria->andWhere(
            Criteria::expr()->eq('isVegan', $this->isVegan)
        );
    }
}
