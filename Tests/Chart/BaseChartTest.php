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

use Leg\GoogleChartsBundle\Charts\BaseChart;

class BaseChartTest extends WebTestCase
{
	public function testSetOptions()
	{
		$chart = new BaseChart();
	
		$chart->setOptions(array(
			'type' => 'bhs',
			'width' => 500,
			'height' => 500,
			'datas' => array(32, 18, 16),
			'labels' => array(31, 'valid'),
			'labels_options' => array(
				'font-size' => 12,
				'position' => 'bv',
				'color' => '000000'
			),
			'colors' => array('ff0000', '00ffff'),
			'title' => 'valid',
			'title_options' => array(
				'font-size' => 12,
				'position' => 'bv',
				'color' => '000000'
			),
			'title_options' => array(
				'font-size' => 12,
				'text-align' => 'center',
				'color' => '000000'
			),
			'transparency' => true,
		));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage Unknown chart option "invalid" or chart method "setInvalid()"
	 */
	public function testSetOptionsInvalid()
	{
		$chart = new BaseChart();
	
		$chart->setOptions(array(
			'invalid' => 'test',
		));
	}
	
	public function testType()
	{
		$chart = new BaseChart();
		$value = 'bhs';
		
		$chart->setType($value);
		
		$this->assertEquals($value, $chart->getType());
	}
	
	public function testWidth()
	{
		$chart = new BaseChart();
		$value = 500;
	
		$chart->setWidth($value);
	
		$this->assertEquals($value, $chart->getWidth());
	}
	
	public function testHeight()
	{
		$chart = new BaseChart();
		$value = 500;
	
		$chart->setHeight($value);
	
		$this->assertEquals($value, $chart->getHeight());
	}
	
	public function testDatas()
	{
		$chart = new BaseChart();
		$value = array(40, 150, 342, 148);
	
		$chart->setDatas($value);
	
		$this->assertEquals($value, $chart->getDatas()->toArray());
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage Datas must be numbers (object given)
	 */
	public function testDatasInvalid()
	{
		$chart = new BaseChart();
		$value = array(new \stdClass());
	
		$chart->setDatas($value);
	}
	
	public function testLabels()
	{
		$chart = new BaseChart();
		$value = array('valid', 150, 342, 148);
	
		$chart->setLabels($value);
	
		$this->assertEquals($value, $chart->getLabels()->toArray());
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage Labels must be numbers or strings (object given)
	 */
	public function testLabelsInvalid()
	{
		$chart = new BaseChart();
		$value = array(new \stdClass());
	
		$chart->setLabels($value);
	}
	
	public function testLabelsOptions()
	{
		$chart = new BaseChart();
		$value = array(
			'font-size' => 12,
			'position' => 'bv',
			'color' => '000000'
		);
	
		$chart->setLabelsOptions($value);
	
		$this->assertEquals($value, $chart->getLabelsOptions()->toArray());
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The label font size must be numeric (array given).
	 */
	public function testLabelsOptionsInvalidFontSize()
	{
		$chart = new BaseChart();
		$chart->setLabelsOptions(array('font-size' => array()));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The label position must be a string (object given)
	 */
	public function testLabelsOptionsInvalidPositionObject()
	{
		$chart = new BaseChart();
		$chart->setLabelsOptions(array('position' => new \stdClass()));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage Unknown label position "invalid". Valid positions are : b, bv, t, tv, r, l.
	 */
	public function testLabelsOptionsInvalidPositionString()
	{
		$chart = new BaseChart();
		$chart->setLabelsOptions(array('position' => 'invalid'));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The label color must be a hexadecimal value ("00000" given).
	 */
	public function testLabelsOptionsInvalidColorString()
	{
		$chart = new BaseChart();
		$chart->setLabelsOptions(array('color' => '00000'));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The label color must be a string (object given)
	 */
	public function testLabelsOptionsInvalidColorObject()
	{
		$chart = new BaseChart();
		$chart->setLabelsOptions(array('color' => new \stdClass()));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage Unknown label option "invalid". Valid options are : position, color, font-size.
	 */
	public function testLabelsOptionsInvalidOption()
	{
		$chart = new BaseChart();
		$chart->setLabelsOptions(array('invalid' => new \stdClass()));
	}
	
	public function testColors()
	{
		$chart = new BaseChart();
		$value = array('000000', 'FFFFFF', '0000FF');
	
		$chart->setColors($value);
	
		$this->assertEquals($value, $chart->getColors()->toArray());
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage A color must be a hexadecimal string ("00000" given).
	 */
	public function testColorsInvalidString()
	{
		$chart = new BaseChart();
		$chart->setColors(array('00000'));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage A color must be a hexadecimal string (object given).
	 */
	public function testColorsInvalidObject()
	{
		$chart = new BaseChart();
		$chart->setColors(array(new \stdClass()));
	}
	
	public function testTitle()
	{
		$chart = new BaseChart();
		$value = 'Title test';
	
		$chart->setTitle($value);
	
		$this->assertEquals($value, $chart->getTitle());
	}
	
	public function testTitleOptions()
	{
		$chart = new BaseChart();
		$value = array(
			'font-size' => 12,
			'text-align' => 'center',
			'color' => '000000'
		);
	
		$chart->setTitleOptions($value);
	
		$this->assertEquals($value, $chart->getTitleOptions()->toArray());
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The title font size must be numeric (array given).
	 */
	public function testTitleOptionsInvalidFontSize()
	{
		$chart = new BaseChart();
		$chart->setTitleOptions(array('font-size' => array()));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The title position must be a string (object given)
	 */
	public function testTitleOptionsInvalidPositionObject()
	{
		$chart = new BaseChart();
		$chart->setTitleOptions(array('text-align' => new \stdClass()));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage Unknown title position "invalid". Valid positions are : left, center, right.
	 */
	public function testTitleOptionsInvalidPositionString()
	{
		$chart = new BaseChart();
		$chart->setTitleOptions(array('text-align' => 'invalid'));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The title color must be a hexadecimal value ("00000" given).
	 */
	public function testTitleOptionsInvalidColorString()
	{
		$chart = new BaseChart();
		$chart->setTitleOptions(array('color' => '00000'));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage The title color must be a string (object given)
	 */
	public function testTitleOptionsInvalidColorObject()
	{
		$chart = new BaseChart();
		$chart->setTitleOptions(array('color' => new \stdClass()));
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
     * @expectedExceptionMessage Unknown title option "invalid". Valid options are : text-align, color, font-size.
	 */
	public function testTitleOptionsInvalidOption()
	{
		$chart = new BaseChart();
		$chart->setTitleOptions(array('invalid' => new \stdClass()));
	}
	
	public function testTransparency()
	{
		$chart = new BaseChart();
	
		$chart->setTransparency(true);
		$this->assertEquals(true, $chart->isTransparent());
	
		$chart->setTransparency(false);
		$this->assertEquals(false, $chart->isTransparent());
	}
	
	public function testBuild()
	{
		$chart = new BaseChart();
	
		$chart	->setWidth(200)
				->setHeight(200)
				->setType('bhs')
				->setDatas(array(32, 15, 17));
		
		$chart->_build();
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
	 * @expectedExceptionMessage A chart must have a type.
	 */
	public function testBuildInvalidType()
	{
		$chart = new BaseChart();
	
		$chart	->setWidth(200)
				->setHeight(200)
				->setDatas(array(32, 15, 17));
		
		$chart->_build();
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
	 * @expectedExceptionMessage A chart must have a width.
	 */
	public function testBuildInvalidWidth()
	{
		$chart = new BaseChart();
	
		$chart	->setHeight(200)
				->setType('bhs')
				->setDatas(array(32, 15, 17));
		
		$chart->_build();
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
	 * @expectedExceptionMessage A chart must have a height.
	 */
	public function testBuildInvalidHeight()
	{
		$chart = new BaseChart();
	
		$chart	->setWidth(200)
				->setType('bhs')
				->setDatas(array(32, 15, 17));
		
		$chart->_build();
	}
	
	/**
	 * @expectedException        InvalidArgumentException
	 * @expectedExceptionCode    500
	 * @expectedExceptionMessage A chart must have datas.
	 */
	public function testBuildInvalidDatas()
	{
		$chart = new BaseChart();
	
		$chart	->setWidth(200)
				->setHeight(200)
				->setType('bhs');
		
		$chart->_build();
	}
}