<?php

namespace AppBundle\RequestDecorator\Decorator;

use Doctrine\Common\Collections\Criteria;

class VeganQueryDecorator implements QueryDecorator
{
    /**
     * {@inheritdoc}
     */
    public function decorate(Criteria $criteria)
    {
        $criteria->where(
            Criteria::expr()->eq('vegan', true)
        );
    }
}
