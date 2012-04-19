<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Charts\Gallery;

use Doctrine\Common\Collections\ArrayCollection;
use Leg\GoogleChartsBundle\Charts\BaseChart;

class BarChart extends BaseChart
{
	/**
	 * @var string
	 */
	protected $type = 'bhs';
	
	/**
	 * @var ArrayCollection
	 */
	protected $axis;
	
	/**
	 * @var integer
	 */
	protected $bar_width;
	
	/**
	 * @var integer
	 */
	protected $bar_spacing;
	
	/**
	 * @var float
	 */
	protected $zero_line;
	

	public function __construct()
	{
		parent::__construct();
		
		$this->axis = new ArrayCollection(array('x', 'y'));
	}
	
	/** 
	 * @see Leg\GoogleChartsBundle\Charts\Model.AbstractChart::build()
	 */
	public function build()
	{
		if($this->axis->isEmpty())
			throw new \InvalidArgumentException('A bar chart must have axis.', 500);
		
		$url = parent::build();
		
		$url .= '&chxt='.implode(',', $this->axis->toArray());
		
		if(! empty($this->bar_width))
		{
			$url .= '&chbh='.$this->bar_width;
		
			if(! empty($this->bar_spacing))
				$url .= ','.$this->bar_spacing;
		}
		elseif(! empty($this->bar_spacing))
			$url .= '&chbh=,'.$this->bar_spacing;
		
		if(! empty($this->zero_line))
			$url .= '&chp='.$this->zero_line;
		
		return $url;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getAxis()
	{
		return $this->axis;
	}
	
	/**
	 * @param array $axis
	 */
	public function setAxis(array $axis)
	{
		foreach($axis as $axe)
		{
			if(! is_string($axe))
			{
				throw new \InvalidArgumentException(sprintf(
					'A visible axe must be a string (%s given)', gettype($axe)
				), 500);
			}
			
			if(! in_array($axe, array('x', 'y', 'r', 't')))
			{
				throw new \InvalidArgumentException(sprintf(
					'Unknown visible axe "%s". Valid axis are x, y, r, t.', $axe
				), 500);
			}
		}
		
		$this->axis = new ArrayCollection($axis);
	
		return $this;
	}
	
	/**
	 * @return integer
	 */
	public function getBarWidth()
	{
		return $this->bar_width;
	}
	
	/**
	 * @param integer $bar_width
	 */
	public function setBarWidth($bar_width)
	{
		$this->bar_width = (int) $bar_width;
	
		return $this;
	}
	
	/**
	 * @return integer
	 */
	public function getBarSpacing()
	{
		return $this->bar_spacing;
	}
	
	/**
	 * @param integer $bar_width
	 */
	public function setBarSpacing($bar_spacing)
	{
		$this->bar_spacing = (int) $bar_spacing;
	
		return $this;
	}
	
	/**
	 * @return float
	 */
	public function getZeroLine()
	{
		return $this->zero_line;
	}
	
	/**
	 * @param float $zero_lines
	 */
	public function setZeroLine($zero_line)
	{
		$this->zero_line = (float) $zero_line;
	
		return $this;
	}
}