<?php

namespace Ql4b\Bundle\GeocodeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('geocode');

        $rootNode
            ->children()
                ->scalarNode('endpoint')
                ->isRequired()
                ->cannotBeEmpty()
                ->end()
            ->scalarNode('key')
                ->isRequired()
                ->cannotBeEmpty()
                ->end()
            ->scalarNode('language')
                ->defaultValue('en')
                ->end()
            ->end();
        
        return $treeBuilder;
    }
}
