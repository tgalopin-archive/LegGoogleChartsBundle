<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Tests\Charts\Gallery;

use Leg\GoogleChartsBundle\Charts\Gallery\BarChart;

class BarChartTest extends \PHPUnit_Framework_TestCase
{
	public function testSetOptions()
	{
		$chart = new BarChart();
	
		$chart->setOptions(array(
			'axis' => array('x', 'y'),
			'bar_width' => 150,
			'bar_spacing' => 10,
			'zero_line' => 0.1,
		));
	}

	public function testAxis()
	{
		$chart = new BarChart();
		$value = array('x', 'y');
		
		$chart->setAxis($value);
		
		$this->assertEquals($value, $chart->getAxis()->toArray());
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
	 * @expectedExceptionMessage Unknown visible axe "invalid". Valid axis are x, y, r, t.
	 */
	public function testAxisInvalidString()
	{
		$chart = new BarChart();
		$chart->setAxis(array('invalid'));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
	 * @expectedExceptionMessage A visible axe must be a string (object given)
	 */
	public function testAxisInvalidObject()
	{
		$chart = new BarChart();
		$chart->setAxis(array(new \stdClass()));
	}
	
	public function testBarWidth()
	{
		$chart = new BarChart();
		$value = 500;
	
		$chart->setBarWidth($value);
	
		$this->assertEquals($value, $chart->getBarWidth());
	}
	
	public function testBarSpacing()
	{
		$chart = new BarChart();
		$value = 500;
	
		$chart->setBarSpacing($value);
	
		$this->assertEquals($value, $chart->getBarSpacing());
	}
	
	public function testZeroLine()
	{
		$chart = new BarChart();
		$value = 0.2;
	
		$chart->setZeroLine($value);
	
		$this->assertEquals($value, $chart->getZeroLine());
	}
	
	public function testBuild()
	{
		$chart = new BarChart();
	
		$chart	->setWidth(200)
				->setHeight(200)
				->setType('bhs')
				->setDatas(array(32, 15, 17))
				->setAxis(array('x', 'y'));
		
		$chart->_build();
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
	 * @expectedExceptionMessage A bar chart must have axis.
	 */
	public function testBuildInvalidType()
	{
		$chart = new BarChart();
	
		$chart	->setWidth(200)
				->setHeight(200)
				->setDatas(array(32, 15, 17))
				->setAxis(array());
		
		$chart->_build();
	}
}