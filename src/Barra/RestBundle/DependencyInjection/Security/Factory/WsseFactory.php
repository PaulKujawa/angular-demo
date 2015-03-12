<?php

namespace Barra\RestBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;


/**
 * Class WsseFactory
 * Hooks into the Security component, telling it the name of the auth. provider and any configuration options available for it
 * Creates services for a unique provider, available for WSSE's part of the firewall
 * @link http://symfony.com/doc/current/cookbook/security/custom_authentication_provider.html#the-factory
 * @see Barra\RestBundle\Security (UserToken, FW Listener, Authentication Provider (Verification)
 * @see Barra\RestBundle\Resources\config\services.yml
 * @package Barra\RestBundle\DependencyInjection\Security\Factory
 */
class WsseFactory implements SecurityFactoryInterface
{
    /**
     * Adds the listener and authentication provider to the DI container for the appropriate security context.
     * @param ContainerBuilder $container
     * @param $id
     * @param $config
     * @param $userProvider
     * @param $defaultEntryPoint
     * @return array
     */
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'security.authentication.provider.wsse.'.$id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('wsse.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProvider))
        ;

        $listenerId = 'security.authentication.listener.wsse.'.$id;
        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('wsse.security.authentication.listener'));

        return array($providerId, $listenerId, $defaultEntryPoint);
    }


    /**
     * Defines the position at which the provider is called.
     * @return string
     */
    public function getPosition()
    {
        return 'pre_auth';
    }


    /**
     * Defines the configuration key used to reference the provider in the firewall configuration
     * @return string
     */
    public function getKey()
    {
        return 'wsse';
    }


    /**
     * Define the configuration options underneath the configuration key in the security.yml
     * @param NodeDefinition $node
     */
    public function addConfiguration(NodeDefinition $node)
    {
    }
}
