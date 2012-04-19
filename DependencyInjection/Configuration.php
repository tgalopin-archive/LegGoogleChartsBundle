<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('leg_google_charts');
		
		$validationClosure = function($v)
		{
			if(isset($v['default_keep_time']))
				return !is_numeric($v['default_keep_time']);
			else
				return false;
		};
		
		$rootNode
            ->validate()
                ->ifTrue($validationClosure)
                ->thenInvalid('The "default_keep_time" must be an integer.')
            ->end()
			->children()
				->arrayNode('cache_engine')
					->addDefaultsIfNotSet()
					->children()
						->booleanNode('enabled')->defaultFalse()->end()
              			->scalarNode('default_keep_time')
              				->defaultValue(3600)
				            ->validate()
				                ->ifTrue()
				                ->thenInvalid('The propel model class must be defined by using the "propel_user_class" key.')
				            ->end()
              			->end()
					->end()
				->end()
			->end();
	
		return $treeBuilder;
	}
}
