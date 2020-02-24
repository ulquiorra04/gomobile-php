<?php

namespace Gomobile\GomobileBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

class GomobileExtension extends Extension
{
	public function load (array $configs, ContainerBuilder $container)
	{
		$configuration = new Configuration ();

		$this->processConfiguration($configuration, $configs);

		// Load service file
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
	}
}