<?php

namespace AppBundle\RequestDecorator\Factory;

use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use Symfony\Component\HttpFoundation\Request;

interface RequestDecoratorFactory
{
    public function createQueryDecorator(Request $request): ?QueryDecorator;
}
