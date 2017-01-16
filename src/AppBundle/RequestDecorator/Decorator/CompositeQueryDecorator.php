<?php

namespace AppBundle\RequestDecorator\Decorator;

use Doctrine\Common\Collections\Criteria;

class CompositeQueryDecorator implements QueryDecorator
{
    /**
     * @var QueryDecorator[]
     */
    private $queryDecorators;

    /**
     * @param array $queryDecorators
     */
    public function __construct(array $queryDecorators)
    {
        $this->queryDecorators = $queryDecorators;
    }

    /**
     * {@inheritdoc}
     */
    public function decorate(Criteria $criteria)
    {
        array_walk($this->queryDecorators, function(QueryDecorator $decorator) use ($criteria) {
           $decorator->decorate($criteria);
        });
    }
}
