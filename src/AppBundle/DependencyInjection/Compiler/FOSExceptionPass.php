<?php

namespace AppBundle\DependencyInjection\Compiler;

use AppBundle\EventListener\AccessDeniedListener;
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
        $definition = $container->getDefinition(AccessDeniedListener::class);

        $definition->replaceArgument('$formats', $fosDefinition->getArgument(0));
        $definition->replaceArgument('$challenge', $fosDefinition->getArgument(1));
        $definition->replaceArgument('$controller', 'twig.controller.exception:showAction');
    }
}
