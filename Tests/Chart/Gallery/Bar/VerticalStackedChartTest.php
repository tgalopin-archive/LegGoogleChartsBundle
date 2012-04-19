<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Tests\Charts\Gallery\Bar;

use Leg\GoogleChartsBundle\Charts\Gallery\Bar\VerticalStackedChart;

class VerticalStackedChartTest extends \PHPUnit_Framework_TestCase
{
	public function testSetOptions()
	{
		$chart = new VerticalStackedChart();
	
		$chart->setOptions(array(
			'stacked_mode' => 'atop',
		));
	}

	public function testStackedMode()
	{
		$chart = new VerticalStackedChart();
		$value = array('x', 'y');
		
		$chart->setAxis($value);
		
		$this->assertEquals($value, $chart->getAxis()->toArray());
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
	 * @expectedExceptionMessage Unknown chart stacked mode "invalid". Valid stacked mode are front and atop.
	 */
	public function testStackedModeInvalidString()
	{
		$chart = new VerticalStackedChart();		
		$chart->setStackedMode('invalid');
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
	 * @expectedExceptionMessage A stacked mode must be a string (object given).
	 */
	public function testStackedModeInvalidObject()
	{
		$chart = new VerticalStackedChart();		
		$chart->setStackedMode(new \stdClass());
	}
}