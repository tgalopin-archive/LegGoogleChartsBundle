<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ChartsDriversCompilerPass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
	{
		if(false === $container->hasDefinition('leg_google_charts'))
			return;

		$definition = $container->getDefinition('leg_google_charts');

		foreach($container->findTaggedServiceIds('leg_google_charts.driver') as $id => $attributes)
		{
			$definition->addMethodCall('addDriver', array(new Reference($id)));
		}
	}
}