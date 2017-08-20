<?php

namespace AppBundle\RequestDecorator\Factory;

use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use AppBundle\RequestDecorator\Decorator\SortNameQueryDecorator;
use Symfony\Component\HttpFoundation\Request;

class SortNameRequestDecoratorFactory implements RequestDecoratorFactory
{
    public function createQueryDecorator(Request $request): ?QueryDecorator
    {
        $direction = strtolower($request->query->get('sortName'));

        return $direction === 'asc' || $direction === 'desc'
            ? new SortNameQueryDecorator($direction)
            : new SortNameQueryDecorator();
    }
}
