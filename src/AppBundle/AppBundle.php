<?php

namespace AppBundle;

use AppBundle\DependencyInjection\Compiler\FOSExceptionPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FOSExceptionPass());
    }
}
