<?php

namespace Leg\GoogleChartsBundle\Chart;
	
class PhpInvalidChartFile
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