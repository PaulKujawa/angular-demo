<?php

namespace Barra\RestBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Barra\RestBundle\DependencyInjection\Security\Factory\WsseFactory;

/**
 * Class BarraRestBundle
 * @package Barra\RestBundle
 */
class BarraRestBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new WsseFactory());
    }
}
