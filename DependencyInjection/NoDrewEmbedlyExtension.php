<?php

namespace NoDrew\Bundle\EmbedlyBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * @package		Embedly
 * @author		Drew Butler <drew@abstracting.me>
 * @copyright	(c) 2012 Drew Butler
 * @license		http://www.opensource.org/licenses/mit-license.php
 */
class NoDrewEmbedlyExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $processor     = new Processor();
        $configuration = new Configuration();

        $config = $processor->process($configuration->getConfigTree(), $configs);
        $loader->load('services.xml');

        $this->setConfig($config, $container);
    }
    
    /**
     * Set the config options.
     *
     * @param array $config
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function setConfig($config, $container)
    {
        $container->setParameter('no_drew_embedly.key', $config['key']);
        
        if (isset($config['options'])) {
            $container->setParameter('no_drew_embedly.options', $config['options']);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespace()
    {
        return 'http://www.nodrew.com/schema/dic/embedly_bundle';
    }
}
