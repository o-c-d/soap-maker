<?php

namespace Ocd\SoapMakerBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root(OcdSoapMakerExtension::CONFIG_NAME);

        $rootNode
            ->children()
                ->scalarNode('soap_client')
                    ->info('Soap client class')
                    ->defaultValue('\SoapClient')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
