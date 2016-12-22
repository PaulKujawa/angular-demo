<?php

namespace AppBundle\RequestDecorator\Decorator;

use Doctrine\Common\Collections\Criteria;

class SortUpdatedQueryDecorator implements QueryDecorator
{
    /**
     * @var string
     */
    private $direction;

    /**
     * @param string $direction
     */
    public function __construct(string $direction = Criteria::ASC)
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
            ['updated' => $this->direction]
        );

        $criteria->orderBy($orderBy);
    }
}
