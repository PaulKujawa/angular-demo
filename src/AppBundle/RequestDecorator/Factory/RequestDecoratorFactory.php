<?php

namespace AppBundle\RequestDecorator\Factory;

use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use Symfony\Component\HttpFoundation\Request;

interface RequestDecoratorFactory
{
    /**
     * @param Request $request
     *
     * @return null|QueryDecorator
     */
    public function createQueryDecorator(Request $request);
}
