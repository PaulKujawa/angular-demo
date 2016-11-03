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

    /**
     * @param RequestDecoratorFactory $decoratorFactory
     * @param int $priority
     */
    public function addFactory(RequestDecoratorFactory $decoratorFactory, $priority = 0)
    {
        $this->factories[] = [
            'factory' => $decoratorFactory,
            'priority' => $priority,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function createQueryDecorator(Request $request)
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
    public function getDecoratorFactories()
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
