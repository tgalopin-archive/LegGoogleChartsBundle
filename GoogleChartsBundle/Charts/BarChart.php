<?php
namespace Leg\GoogleChartsBundle\Charts;

use Doctrine\Common\Collections\ArrayCollection;

use Leg\GoogleChartsBundle\Charts\Model\AbstractChart;

class BarChart extends AbstractChart
{
	/**
	 * @var string
	 */
	protected $type = 'bhs';
	
	/**
	 * @var ArrayCollection
	 */
	protected $axsis;
	
	/**
	 * @var integer
	 */
	protected $bar_width;
	
	/**
	 * @var integer
	 */
	protected $bar_spacing;
	
	/**
	 * @var ArrayCollection
	 */
	protected $zero_lines;
	

	public function __construct()
	{
		parent::__construct();
		
		$this->zero_lines = new ArrayCollection();
		$this->axsis = new ArrayCollection(array('x', 'y'));
	}
	
	/** 
	 * @see Leg\GoogleChartsBundle\Charts\Model.AbstractChart::build()
	 */
	public function build()
	{
		$url = parent::build();
		
		$url .= '&chxt='.implode(',', $this->axsis->toArray());
		
		if(!empty($this->bar_width))
			$url .= '&chbh='.$this->bar_spacing;
		
		if(!empty($this->bar_spacing))
			$url .= ','.$this->bar_spacing;
		
		if(! $this->zero_lines->isEmpty())
			$url .= '&chp='.implode(',', $this->zero_lines->toArray());
		
		return $url;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getAxsis()
	{
		return $this->axsis;
	}
	
	/**
	 * @param ArrayCollection $axsis
	 */
	public function setAxsis(ArrayCollection $axsis)
	{
		$this->axsis = $axsis;
	
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
	 * @return ArrayCollection
	 */
	public function getZeroLines()
	{
		return $this->zero_lines;
	}
	
	/**
	 * @param ArrayCollection $zero_lines
	 */
	public function setZeroLines(ArrayCollection $zero_lines)
	{
		$this->zero_lines = $zero_lines;
	
		return $this;
	}
}