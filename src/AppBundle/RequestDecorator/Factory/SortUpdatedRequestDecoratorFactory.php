<?php

namespace AppBundle\RequestDecorator\Factory;

use AppBundle\RequestDecorator\Decorator\SortUpdatedQueryDecorator;
use Symfony\Component\HttpFoundation\Request;

class SortUpdatedRequestDecoratorFactory implements RequestDecoratorFactory
{
    /**
     * {@inheritdoc}
     */
    public function createQueryDecorator(Request $request)
    {
        $direction = strtolower($request->query->get('sortUpdated'));

        return $direction === 'asc' || $direction === 'desc'
            ? new SortUpdatedQueryDecorator($direction)
            : null;
    }
}
