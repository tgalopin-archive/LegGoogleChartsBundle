<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Charts\Gallery\Bar;

use Leg\GoogleChartsBundle\Charts\Gallery\BarChart;

class VerticalStackedChart extends BarChart
{
	protected $type = 'bvs';
	
	/**
	 * Set the stacked mode for the bars
	 * 
	 * 		atop : 	Vertical bar chart in which bars
	 * 				are stacked atop of one another.
	 * 		front : Vertical bar chart in which bars
	 * 				are stacked front of one another.
	 * 
	 * @param atop|front $mode
	 */
	public function setStackedMode($mode)
	{
		if(! is_string($mode))
		{
			throw new \InvalidArgumentException(sprintf(
				'A stacked mode must be a string (%s given).',
				gettype($mode)
			), 500);
		}
		
		if($mode == 'front')
		{
			$this->type = 'bvo';
		}
		elseif($mode == 'atop')
		{
			$this->type = 'bvs';
		}
		else
		{
			throw new \InvalidArgumentException(sprintf(
				'Unknown chart stacked mode "%s". Valid stacked mode are front and atop.',
				$mode
			), 500);
		}
	}
	
	/**
	 * Get the stacked mode for the bars
	 * 
	 * @return atop|front
	 */
	public function getStackedMode($mode)
	{
		if($this->type == 'bvo')
			return 'front';
		else
			return 'atop';
	}
}