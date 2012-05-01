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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Leg\GoogleChartsBundle\Charts\Gallery\PieChart;

class PieChartTest extends WebTestCase
{
	public function testSetOptions()
	{
		$chart = new PieChart();
	
		$chart->setOptions(array(
			'rotation' => 0.628
		));
	}

	public function testRotation()
	{
		$chart = new PieChart();
		$value = 1.524;
		
		$chart->setRotation($value);
		
		$this->assertEquals($value, $chart->getRotation());
	}
}