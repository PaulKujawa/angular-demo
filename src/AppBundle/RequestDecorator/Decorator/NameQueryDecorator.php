<?php

namespace AppBundle\RequestDecorator\Decorator;

use Doctrine\Common\Collections\Criteria;

class NameQueryDecorator implements QueryDecorator
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function decorate(Criteria $criteria): void
    {
        $criteria->andWhere(
            Criteria::expr()->contains('name', $this->name)
        );
    }
}
