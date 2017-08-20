<?php

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @see https://github.com/FriendsOfSymfony/FOSRestBundle/issues/1538
 */
class FOSExceptionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $fosDefinition = $container->getDefinition('fos_rest.access_denied_listener');
        $definition = $container->getDefinition('app.event_listener.access_denied_listener');

        $definition->replaceArgument(0, $fosDefinition->getArgument(0));
        $definition->replaceArgument(1, $fosDefinition->getArgument(1));
        $definition->replaceArgument(2, 'twig.controller.exception:showAction');
    }
}
