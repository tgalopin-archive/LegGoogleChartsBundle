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

use Leg\GCharts\ChartInterface;
use Leg\GCharts\Gallery\BarChart;
use Leg\GoogleChartsBundle\Drivers\YmlFileDriver;
use Leg\GoogleChartsBundle\Tests\TestCase;

class YmlFileDriverTest extends TestCase
{
	public function testSupports()
	{
		$driver = new YmlFileDriver($this->createKernel());

		$this->assertFalse($driver->supports('SymfonyMainBunde:Example.xml'));
		$this->assertFalse($driver->supports('SymfonyMainBunde:Example.yml.xml'));
		$this->assertFalse($driver->supports('Unsupported.yml.xml'));
		$this->assertTrue($driver->supports('SymfonyMainBunde:Example.yml'));
		$this->assertTrue($driver->supports('SymfonyMainBunde:Example.xml.yml'));
		$this->assertTrue($driver->supports('Supported.yml'));
	}

	public function testValidImport()
	{
		$driver = new YmlFileDriver($this->createKernel());

		$chart = $driver->import('LegGoogleChartsBundle:YmlValidChartFile.yml');

		$this->assertTrue($chart instanceof ChartInterface);
		$this->assertTrue($chart instanceof BarChart);
	}

	/**
	 * @expectedException        \InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The file "NotFound.yml" does not exist.
	 */
	public function testInvalidImport()
	{
		$driver = new YmlFileDriver($this->createKernel());
		$driver->import('LegGoogleChartsBundle:NotFound.yml');
	}

	/**
	 * @expectedException        \RuntimeException
	 * @expectedExceptionCode    500
	 */
	public function testImportWithInvalidExtend()
	{
		$driver = new YmlFileDriver($this->createKernel());
		$driver->import('LegGoogleChartsBundle:YmlWithInvalidExtendChartFile.yml');
	}

	/**
	 * @expectedException        \RuntimeException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The YAML charts driver has not found extended chart class in "YmlWithoutExtendChartFile.yml"
	 */
	public function testImportWithoutExtend()
	{
		$driver = new YmlFileDriver($this->createKernel());
		$driver->import('LegGoogleChartsBundle:YmlWithoutExtendChartFile.yml');
	}
}