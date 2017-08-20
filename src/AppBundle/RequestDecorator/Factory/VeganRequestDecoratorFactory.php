<?php

namespace AppBundle\RequestDecorator\Factory;

use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use AppBundle\RequestDecorator\Decorator\VeganQueryDecorator;
use Symfony\Component\HttpFoundation\Request;

class VeganRequestDecoratorFactory implements RequestDecoratorFactory
{
    public function createQueryDecorator(Request $request): ?QueryDecorator
    {
        $isVegan = $request->query->getBoolean('vegan');

        return $isVegan
            ? new VeganQueryDecorator($isVegan)
            : null;
    }
}
