<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Tests\Drivers;

use Leg\GCharts\Gallery\BarChart;
use Leg\GoogleChartsBundle\ChartsManager;
use Leg\GoogleChartsBundle\Drivers\XmlFileDriver;
use Leg\GoogleChartsBundle\Drivers\YmlFileDriver;
use Leg\GoogleChartsBundle\Drivers\PhpFileDriver;
use Leg\GoogleChartsBundle\Twig\LegGoogleChartsExtension;
use Leg\GoogleChartsBundle\Tests\TestCase;

class LegGoogleChartsExtensionTest extends TestCase
{
	public function testCreate()
	{
		$kernel = $this->createKernel();

		$manager = new ChartsManager($kernel, false, 3600);

		$manager->addDriver(new PhpFileDriver($kernel));
		$manager->addDriver(new YmlFileDriver($kernel));
		$manager->addDriver(new XmlFileDriver($kernel));

		return new LegGoogleChartsExtension($manager);
	}

	/**
	 * @depends testCreate
	 */
	public function testGetChart(LegGoogleChartsExtension $extension)
	{
		$chart = $extension->get('LegGoogleChartsBundle:PhpValidChartFile.php');
		$this->assertTrue($chart instanceof BarChart);

		$chart = $extension->get('LegGoogleChartsBundle:XmlValidChartFile.xml');
		$this->assertTrue($chart instanceof BarChart);

		$chart = $extension->get('LegGoogleChartsBundle:YmlValidChartFile.yml');
		$this->assertTrue($chart instanceof BarChart);
	}

	/**
	 * @depends                  testCreate
	 * @expectedException        \RuntimeException
	 * @expectedExceptionCode    500
	 * @expectedExceptionMessage No driver supports the resource "LegGoogleChartsBundle:Unsupported.ext".
	 */
	public function testGetUnsupportedChart(LegGoogleChartsExtension $extension)
	{
		$extension->get('LegGoogleChartsBundle:Unsupported.ext');
	}
}