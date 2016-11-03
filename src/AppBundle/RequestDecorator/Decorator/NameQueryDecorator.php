<?php

namespace AppBundle\RequestDecorator\Decorator;

use Doctrine\Common\Collections\Criteria;

class NameQueryDecorator implements QueryDecorator
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function decorate(Criteria $criteria)
    {
        $criteria->where(
            Criteria::expr()->contains('name', $this->name)
        );
    }
}
