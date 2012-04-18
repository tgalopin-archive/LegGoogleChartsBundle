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

use Leg\GoogleChartsBundle\Drivers\XmlFileDriver;
use Leg\GoogleChartsBundle\Charts\Gallery\BarChart;
use Leg\GoogleChartsBundle\Charts\ChartInterface;

class XmlFileDriverTest extends WebTestCase
{
	public function testSupports()
	{
		$driver = new XmlFileDriver(parent::createKernel());
		
		$this->assertFalse($driver->supports('SymfonyMainBunde:Example.php'));
		$this->assertFalse($driver->supports('SymfonyMainBunde:Example.xml.php'));
		$this->assertFalse($driver->supports('Unsupported.xml.php'));
		$this->assertTrue($driver->supports('SymfonyMainBunde:Example.xml'));
		$this->assertTrue($driver->supports('SymfonyMainBunde:Example.php.xml'));
		$this->assertTrue($driver->supports('Supported.xml'));
	}

	public function testValidImport()
	{
		$kernel = new \AppKernel('dev', true);
		$kernel->boot();
		
		$driver = new XmlFileDriver($kernel);
	
		$chart = $driver->import('LegGoogleChartsBundle:XmlValidChartFile.xml');
		
		$this->assertTrue($chart instanceof ChartInterface);
		$this->assertTrue($chart instanceof BarChart);
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The file "NotFound.xml" does not exist.
	 */
	public function testInvalidImport()
	{
		$kernel = new \AppKernel('dev', true);
		$kernel->boot();
		
		$driver = new XmlFileDriver($kernel);
	
		$chart = $driver->import('LegGoogleChartsBundle:NotFound.xml');
	}
	
	/**
	 * @expectedException        RuntimeException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The XML charts driver has not found Leg\GoogleChartsBundle\Charts\Gallery\InvalidChart in "XmlWithInvalidExtendChartFile.xml"
	 */
	public function testImportWithInvalidExtend()
	{
		$kernel = new \AppKernel('dev', true);
		$kernel->boot();
		
		$driver = new XmlFileDriver($kernel);
	
		$chart = $driver->import('LegGoogleChartsBundle:XmlWithInvalidExtendChartFile.xml');
	}
	
	/**
	 * @expectedException        RuntimeException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The XML charts driver has not found extended chart class in "XmlWithoutExtendChartFile.xml"
	 */
	public function testImportWithoutExtend()
	{
		$kernel = new \AppKernel('dev', true);
		$kernel->boot();
		
		$driver = new XmlFileDriver($kernel);
	
		$chart = $driver->import('LegGoogleChartsBundle:XmlWithoutExtendChartFile.xml');
	}
}