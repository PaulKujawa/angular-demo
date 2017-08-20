<?php

namespace AppBundle\RequestDecorator\Factory;

use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use AppBundle\RequestDecorator\Decorator\SortUpdatedQueryDecorator;
use Symfony\Component\HttpFoundation\Request;

class SortUpdatedRequestDecoratorFactory implements RequestDecoratorFactory
{
    public function createQueryDecorator(Request $request): ?QueryDecorator
    {
        $direction = strtolower($request->query->get('sortUpdated'));

        return $direction === 'asc' || $direction === 'desc'
            ? new SortUpdatedQueryDecorator($direction)
            : null;
    }
}
