<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Tests\Charts;

use Leg\GCharts\Gallery\BarChart;
use Leg\GoogleChartsBundle\ChartsManager;
use Leg\GoogleChartsBundle\Drivers\DriverInterface;
use Leg\GoogleChartsBundle\Drivers\PhpFileDriver;
use Leg\GoogleChartsBundle\Drivers\XmlFileDriver;
use Leg\GoogleChartsBundle\Drivers\YmlFileDriver;
use Leg\GoogleChartsBundle\Tests\TestCase;

class ChartsManagerTest extends TestCase
{
	public function testCreate()
	{
		return new ChartsManager($this->createKernel(), false, 3600);
	}

	/**
	 * @depends testCreate
	 */
	public function testAddDriver(ChartsManager $manager)
	{
		$driver = new PhpFileDriver($this->createKernel());
		$manager->addDriver($driver);
		$this->assertArrayHasKey('PhpFileDriver', $manager->getDrivers()->toArray());

		return $manager;
	}

	/**
	 * @depends testAddDriver
	 */
	public function testGetDriver(ChartsManager $manager)
	{
		$driver = $manager->getDriver('PhpFileDriver');
		$this->assertTrue($driver instanceof DriverInterface);
		$this->assertTrue($driver instanceof PhpFileDriver);

		return $manager;
	}

	/**
	 * @depends testGetDriver
	 */
	public function testRemoveByNameDriver(ChartsManager $manager)
	{
		$manager->removeDriver('PhpFileDriver');
		$this->assertEmpty($manager->getDrivers()->toArray());
	}

	/**
	 * @depends testGetDriver
	 */
	public function testRemoveByInstanceDriver(ChartsManager $manager)
	{
		$driver = new PhpFileDriver($this->createKernel());
		$manager->removeDriver($driver);
		$this->assertEmpty($manager->getDrivers()->toArray());
	}

	public function testGetChart()
	{
		$kernel = $this->createKernel();

		$manager = new ChartsManager($kernel, false, 3600);

		$manager->addDriver(new PhpFileDriver($kernel));
		$manager->addDriver(new YmlFileDriver($kernel));
		$manager->addDriver(new XmlFileDriver($kernel));

		$chart = $manager->get('LegGoogleChartsBundle:PhpValidChartFile.php');
		$this->assertTrue($chart instanceof BarChart);

		$chart = $manager->get('LegGoogleChartsBundle:XmlValidChartFile.xml');
		$this->assertTrue($chart instanceof BarChart);

		$chart = $manager->get('LegGoogleChartsBundle:YmlValidChartFile.yml');
		$this->assertTrue($chart instanceof BarChart);
	}

	/**
	 * @expectedException        \RuntimeException
	 * @expectedExceptionCode    500
	 * @expectedExceptionMessage No driver supports the resource "LegGoogleChartsBundle:PhpValidChartFile.php".
	 */
	public function testGetUnsupportedChart()
	{
		$manager = new ChartsManager($this->createKernel(), false, 3600);

		$manager->get('LegGoogleChartsBundle:PhpValidChartFile.php');
	}
}