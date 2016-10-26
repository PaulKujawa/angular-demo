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
        $direction = $request->query->get('sortName');

        return in_array($direction, ['asc', 'desc'])
            ? new SortNameQueryDecorator($direction)
            : null;
    }
}
