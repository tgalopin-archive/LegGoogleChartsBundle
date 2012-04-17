<?php
namespace Leg\GoogleChartsBundle\Charts\Bar;

use Leg\GoogleChartsBundle\Charts\BarChart;

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
		if($mode == 'front')
		{
			$this->type = 'bvo';
		}
		else
		{
			$this->type = 'bvs';
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
		{
			 return 'front';
		}
		else
		{
			return 'atop';
		}
	}
}