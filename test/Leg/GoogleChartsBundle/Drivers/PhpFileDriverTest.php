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
use Leg\GoogleChartsBundle\Drivers\PhpFileDriver;
use Leg\GoogleChartsBundle\Tests\TestCase;

class PhpFileDriverTest extends TestCase
{
	public function testSupports()
	{
		$driver = new PhpFileDriver(parent::createKernel());

		$this->assertFalse($driver->supports('SymfonyMainBunde:Example.xml'));
		$this->assertFalse($driver->supports('SymfonyMainBunde:Example.php.xml'));
		$this->assertFalse($driver->supports('Unsupported.php.xml'));
		$this->assertTrue($driver->supports('SymfonyMainBunde:Example.php'));
		$this->assertTrue($driver->supports('SymfonyMainBunde:Example.xml.php'));
		$this->assertTrue($driver->supports('Supported.php'));
	}

	public function testValidImport()
	{
		$driver = new PhpFileDriver($this->createKernel());

		$chart = $driver->import('LegGoogleChartsBundle:PhpValidChartFile.php');

		$this->assertTrue($chart instanceof ChartInterface);
		$this->assertTrue($chart instanceof BarChart);
	}

	/**
	 * @expectedException        \RuntimeException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The class "Leg\GoogleChartsBundle\Chart\PhpInvalidChartFile" can not be used as a chart class.
	 */
	public function testInvalidImportExists()
	{
		$driver = new PhpFileDriver($this->createKernel());
		$driver->import('LegGoogleChartsBundle:PhpInvalidChartFile.php');
	}

	/**
	 * @expectedException        \RuntimeException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The PHP charts driver expected class "Leg\GoogleChartsBundle\Chart\NotFoundPhpFile" to be defined in file "Leg\GoogleChartsBundle\Chart\NotFoundPhpFile.php".
				You probably have a typo in the namespace or the class name.
	 */
	public function testInvalidImportNotFound()
	{
		$driver = new PhpFileDriver($this->createKernel());
		$driver->import('LegGoogleChartsBundle:NotFoundPhpFile.php');
	}
}