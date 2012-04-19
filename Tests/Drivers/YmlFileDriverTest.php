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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Leg\GoogleChartsBundle\Drivers\YmlFileDriver;
use Leg\GoogleChartsBundle\Charts\Gallery\BarChart;
use Leg\GoogleChartsBundle\Charts\ChartInterface;

class YmlFileDriverTest extends WebTestCase
{
	public function testSupports()
	{
		$driver = new YmlFileDriver(parent::createKernel());
		
		$this->assertFalse($driver->supports('SymfonyMainBunde:Example.xml'));
		$this->assertFalse($driver->supports('SymfonyMainBunde:Example.yml.xml'));
		$this->assertFalse($driver->supports('Unsupported.yml.xml'));
		$this->assertTrue($driver->supports('SymfonyMainBunde:Example.yml'));
		$this->assertTrue($driver->supports('SymfonyMainBunde:Example.xml.yml'));
		$this->assertTrue($driver->supports('Supported.yml'));
	}

	public function testValidImport()
	{
		$kernel = new \AppKernel('dev', true);
		$kernel->boot();
		
		$driver = new YmlFileDriver($kernel);
	
		$chart = $driver->import('LegGoogleChartsBundle:YmlValidChartFile.yml');
		
		$this->assertTrue($chart instanceof ChartInterface);
		$this->assertTrue($chart instanceof BarChart);
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The file "NotFound.yml" does not exist.
	 */
	public function testInvalidImport()
	{
		$kernel = new \AppKernel('dev', true);
		$kernel->boot();
		
		$driver = new YmlFileDriver($kernel);
	
		$chart = $driver->import('LegGoogleChartsBundle:NotFound.yml');
	}
	
	/**
	 * @expectedException        RuntimeException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The YAML charts driver has not found Leg\GoogleChartsBundle\Charts\Gallery\InvalidChart in "YmlWithInvalidExtendChartFile.yml"
	 */
	public function testImportWithInvalidExtend()
	{
		$kernel = new \AppKernel('dev', true);
		$kernel->boot();
		
		$driver = new YmlFileDriver($kernel);
	
		$chart = $driver->import('LegGoogleChartsBundle:YmlWithInvalidExtendChartFile.yml');
	}
	
	/**
	 * @expectedException        RuntimeException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The YAML charts driver has not found extended chart class in "YmlWithoutExtendChartFile.yml"
	 */
	public function testImportWithoutExtend()
	{
		$kernel = new \AppKernel('dev', true);
		$kernel->boot();
		
		$driver = new YmlFileDriver($kernel);
	
		$chart = $driver->import('LegGoogleChartsBundle:YmlWithoutExtendChartFile.yml');
	}
}