<?php

namespace AppBundle\RequestDecorator\Factory;

use AppBundle\RequestDecorator\Decorator\CompositeQueryDecorator;
use Symfony\Component\HttpFoundation\Request;

class CompositeRequestDecoratorFactory implements RequestDecoratorFactory
{
    /**
     * @var array
     */
    private $factories = [];

    public function addFactory(RequestDecoratorFactory $decoratorFactory, int $priority = 0): void
    {
        $this->factories[] = [
            'factory' => $decoratorFactory,
            'priority' => $priority,
        ];
    }

    public function createQueryDecorator(Request $request): CompositeQueryDecorator
    {
        $queryDecorators = array_map(function(RequestDecoratorFactory $factory) use ($request) {
            return $factory->createQueryDecorator($request);
        }, $this->getDecoratorFactories());

        $matchedQueryDecorators = array_values(array_filter($queryDecorators));

        return new CompositeQueryDecorator($matchedQueryDecorators);
    }

    /**
     * @return RequestDecoratorFactory[]
     */
    public function getDecoratorFactories(): array
    {
        $this->sortFactories();

        return array_map(function(array $factory) {
            return $factory['factory'];
        }, $this->factories);
    }

    private function sortFactories()
    {
        usort($this->factories, function (array $a, array $b) {
            return $a['priority'] > $b['priority'] ? -1 : 1;
        });
    }
}
