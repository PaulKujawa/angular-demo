<?php

namespace AppBundle\RequestDecorator\Decorator;

use Doctrine\Common\Collections\Criteria;

class VeganQueryDecorator implements QueryDecorator
{
    /**
     * @var bool
     */
    private $isVegan;

    /**
     * @param bool $isVegan
     */
    public function __construct($isVegan)
    {
        $this->isVegan = $isVegan;
    }

    /**
     * {@inheritdoc}
     */
    public function decorate(Criteria $criteria)
    {
        $criteria->andWhere(
            Criteria::expr()->eq('isVegan', $this->isVegan)
        );
    }
}
