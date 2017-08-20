<?php

namespace AppBundle\RequestDecorator\Decorator;

use Doctrine\Common\Collections\Criteria;

class CompositeQueryDecorator implements QueryDecorator
{
    /**
     * @var QueryDecorator[]
     */
    private $queryDecorators;

    public function __construct(array $queryDecorators)
    {
        $this->queryDecorators = $queryDecorators;
    }

    public function decorate(Criteria $criteria): void
    {
        array_walk($this->queryDecorators, function(QueryDecorator $decorator) use ($criteria) {
           $decorator->decorate($criteria);
        });
    }
}
