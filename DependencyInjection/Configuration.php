<?php

namespace Gomobile\GomobileBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
	public function getConfigTreeBuilder ()
	{
		$treeBuilder = new TreeBuilder("gomobile");
		$rootNode = $treeBuilder->getRootNode();

		$rootNode->children()
				 ->scalarNode('login')->defaultValue('')->end()
				 ->scalarNode('password')->defaultValue('')->end()
				 ->booleanNode('demo')->defaultFalse()->end()
				 ->end();
				 
		return $treeBuilder;
	}
}