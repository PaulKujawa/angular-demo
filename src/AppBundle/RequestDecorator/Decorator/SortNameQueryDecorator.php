<?php

namespace AppBundle\RequestDecorator\Decorator;

use Doctrine\Common\Collections\Criteria;

class SortNameQueryDecorator implements QueryDecorator
{
    /**
     * @var string
     */
    private $direction;

    /**
     * @param string $direction
     */
    public function __construct($direction)
    {
        $this->direction = $direction;
    }

    /**
     * {@inheritdoc}
     */
    public function decorate(Criteria $criteria)
    {
        $orderBy = array_merge(
            $criteria->getOrderings(),
            ['name' => $this->direction]
        );

        $criteria->orderBy($orderBy);
    }
}
