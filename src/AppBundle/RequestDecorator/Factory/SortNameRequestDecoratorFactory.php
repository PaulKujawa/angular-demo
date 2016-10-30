<?php

namespace AppBundle\RequestDecorator\Factory;

use AppBundle\RequestDecorator\Decorator\SortNameQueryDecorator;
use Symfony\Component\HttpFoundation\Request;

class SortNameRequestDecoratorFactory implements RequestDecoratorFactory
{
    /**
     * {@inheritdoc}
     */
    public function createQueryDecorator(Request $request)
    {
        $direction = strtolower($request->query->get('sortName'));

        return $direction === 'asc' || $direction === 'desc'
            ? new SortNameQueryDecorator($direction)
            : new SortNameQueryDecorator();
    }
}
