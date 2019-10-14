<?php

namespace Ocd\SoapMakerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class OcdSoapMakerExtension extends Extension
{
    const CONFIG_NAME = 'ocd_soap_maker';
    const CONFIG_KEY = self::CONFIG_NAME.'.config';

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(self::CONFIG_KEY, $config);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
        
        $container->setParameter(self::CONFIG_NAME.'.soap_client', isset($config['soap_client']) ? $config['soap_client'] : null);
    }
}
