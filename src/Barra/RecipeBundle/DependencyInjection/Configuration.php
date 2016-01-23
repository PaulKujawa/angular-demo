<?php

namespace Barra\RecipeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        // definition of provided configuration possibilities for this bundle

        $treeBuilder = new TreeBuilder();
//        $rootNode = $treeBuilder->root('barra_recipe');

        return $treeBuilder;
    }
}
