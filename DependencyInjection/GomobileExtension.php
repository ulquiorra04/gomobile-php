<?php

namespace Gomobile\GomobileBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

class GomobileExtension extends Extension
{
	public function load (array $configs, ContainerBuilder $container)
	{
		$configuration = new Configuration ();

		$config = $this->processConfiguration($configuration, $configs);

		// Set parameters
        $container->setParameter('gomobile.login', $config['login']);
        $container->setParameter('gomobile.password', $config['password']);
        $container->setParameter('gomobile.demo', $config['demo']);

		// Load service file
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
	}
}
