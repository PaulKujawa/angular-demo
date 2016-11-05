<?php

namespace AppBundle\RequestDecorator\Factory;

use AppBundle\RequestDecorator\Decorator\VeganQueryDecorator;
use Symfony\Component\HttpFoundation\Request;

class VeganRequestDecoratorFactory implements RequestDecoratorFactory
{
    /**
     * {@inheritdoc}
     */
    public function createQueryDecorator(Request $request)
    {
        $isVegan = $request->query->getBoolean('vegan');

        return $isVegan
            ? new VeganQueryDecorator($isVegan)
            : null;
    }
}
