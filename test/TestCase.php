<?php

/*
 * This file is part of the LegGCharts package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Tests;

/**
 * TestCase is the base class for tests
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
	public function createKernel()
	{
		$kernel = new \AppKernel('dev', true);
		$kernel->boot();

		return $kernel;
	}
}
