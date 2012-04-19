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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Leg\GoogleChartsBundle\Charts\ChartsManager;
use Leg\GoogleChartsBundle\Charts\Gallery\BarChart;
use Leg\GoogleChartsBundle\Drivers\DriverInterface;
use Leg\GoogleChartsBundle\Drivers\PhpFileDriver;
use Leg\GoogleChartsBundle\Drivers\XmlFileDriver;
use Leg\GoogleChartsBundle\Drivers\YmlFileDriver;

class ChartsManagerTest extends WebTestCase
{
	public function testCreate()
	{
		$manager = new ChartsManager(parent::createKernel());
		
		return $manager;
	}
	
	/**
	 * @depends testCreate
	 */
	public function testAddDriver(ChartsManager $manager)
	{
		$kernel = parent::createKernel();
		
		$driver = new PhpFileDriver(parent::createKernel());
		
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
		$driver = new PhpFileDriver(parent::createKernel());
		
		$manager->removeDriver($driver);
		
		$this->assertEmpty($manager->getDrivers()->toArray());
	}
	
	public function testGetChart()
	{
		$manager = new ChartsManager(parent::createKernel());
		
		$kernel = new \AppKernel('dev', true);
		$kernel->boot();
		
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
	 * @expectedException        RuntimeException
	 * @expectedExceptionCode    500
	 * @expectedExceptionMessage No driver supports the resource "LegGoogleChartsBundle:PhpValidChartFile.php".
	 */
	public function testGetUnsupportedChart()
	{
		$manager = new ChartsManager(parent::createKernel());
		
		$chart = $manager->get('LegGoogleChartsBundle:PhpValidChartFile.php');
	}
}