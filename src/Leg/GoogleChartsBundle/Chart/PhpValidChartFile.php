<?php

namespace Leg\GoogleChartsBundle\Chart;

use Leg\GCharts\Gallery\BarChart;

class PhpValidChartFile extends BarChart
{
	public function getDefaultOptions()
	{
		return array(
			'width' => 200,
			'height' => 200,
			'datas' => array(100, 75, 45)
		);
	}
}