<?php

namespace AppBundle\RequestDecorator\Factory;

use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use AppBundle\RequestDecorator\Decorator\NameQueryDecorator;
use Symfony\Component\HttpFoundation\Request;

class NameRequestDecoratorFactory implements RequestDecoratorFactory
{
    public function createQueryDecorator(Request $request): ?QueryDecorator
    {
        $title = $request->query->get('name');

        return null !== $title
            ? new NameQueryDecorator($title)
            : null;
    }
}
