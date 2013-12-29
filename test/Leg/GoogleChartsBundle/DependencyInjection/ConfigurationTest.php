<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Tests\DependencyInjection;

use Leg\GoogleChartsBundle\Tests\TestCase;

class ConfigurationTest extends TestCase
{
	public function testConfiguration()
	{
		$container = $this->createKernel()->getContainer();

		$this->assertTrue($container->hasParameter('leg_google_charts.cache_engine.enabled'));
		$this->assertTrue($container->hasParameter('leg_google_charts.cache_engine.default_keep_time'));
	}
}