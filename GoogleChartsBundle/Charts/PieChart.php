<?php
namespace Leg\GoogleChartsBundle\Charts;

use Leg\GoogleChartsBundle\Charts\Model\AbstractChart;

class PieChart extends AbstractChart
{
	protected $type = 'p';
	
	/**
	 * @var integer
	 */
	protected $rotation;
	
	public function build()
	{
		$url = parent::build();
		
		$url .= '&chp='.$this->rotation;
		
		return $url;
	}
	
	/**
	 * Get rotation
	 * @return integer
	 */
	public function getRotation()
	{
		return $this->rotation;
	}
	
	/**
	 * Set rotation 
	 * @param integer $rotation
	 * @return integer
	 */
	public function setRotation($rotation)
	{
		$this->rotation = (int) $rotation;
		
		return $this;
	}
}