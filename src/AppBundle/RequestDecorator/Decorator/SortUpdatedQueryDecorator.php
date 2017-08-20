<?php

namespace AppBundle\RequestDecorator\Decorator;

use Doctrine\Common\Collections\Criteria;

class SortUpdatedQueryDecorator implements QueryDecorator
{
    /**
     * @var string
     */
    private $direction;

    public function __construct(string $direction = Criteria::ASC)
    {
        $this->direction = $direction;
    }

    public function decorate(Criteria $criteria): void
    {
        $orderBy = array_merge(
            $criteria->getOrderings(),
            ['updated' => $this->direction]
        );

        $criteria->orderBy($orderBy);
    }
}
