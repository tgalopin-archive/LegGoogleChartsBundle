<?php
namespace Leg\GoogleChartsBundle\Charts\Model;

use Leg\GoogleChartsBundle\CacheEngine\ChartsCacheEngine;

use Doctrine\Common\Collections\ArrayCollection;

class AbstractChart
{
	/**
	 * @var string
	 */
	const BASE_URL = 'https://chart.googleapis.com/chart?';
	
	/**
	 * @var string
	 */
	protected $type;
	
	/**
	 * @var integer
	 */
	protected $width;
	
	/**
	 * @var integer
	 */
	protected $height;
	
	/**
	 * @var ArrayCollection
	 */
	protected $datas;
	
	/**
	 * @var ArrayCollection
	 */
	protected $labels;
	
	/**
	 * @var ArrayCollection
	 */
	protected $labels_options;
	
	/**
	 * @var ArrayCollection
	 */
	protected $colors;
	
	/**
	 * @var string
	 */
	protected $title;
	
	/**
	 * @var ArrayCollection
	 */
	protected $title_options;
	
	/**
	 * @var boolean
	 */
	protected $transparency;
	
	/**
	 * @var ArrayCollection
	 */
	protected $margins;

	public function __construct()
	{
		$this->datas = new ArrayCollection();
		$this->labels = new ArrayCollection();
		$this->labels_options = new ArrayCollection();
		$this->colors = new ArrayCollection();
		$this->title_options = new ArrayCollection();
		
		$this->margins = new ArrayCollection(array(
			'top' => '',
			'bottom' => '',
			'left' => '',
			'right' => '',
			'legend-width' => '',
			'legend-height' => ''
		));
		
		$this->setOptions($this->getDefaultOptions());
	}
	
	/**
	 * Set options
	 * @param array $options
	 */
	public function setOptions(array $options)
	{		
		foreach($options as $option => $value)
		{
			$funcName = array_map('ucfirst', explode('_', $option));				
			$funcName = 'set'.implode('', $funcName);
			
			if(method_exists($this, $funcName))
			{
				if(is_array($value))
				{
					$value = new ArrayCollection($value);
				}
				
				$this->$funcName($value);
			}
		}
	}
	
	/**
	 * To override to set default options for a chart
	 * (used into charts class)
	 * @return array
	 */
	public function getDefaultOptions()
	{
		return array();
	}
	
	/**
	 * Build and return URI
	 * @return string
	 */
	public function build()
	{		
		if($this->datas->isEmpty() OR empty($this->width) OR empty($this->height))
		{
			throw new \InvalidArgumentException(sprintf(
				'A chart must have datas and size.',
				$methodName, $name
			));
		}
		
		$url = 'https://chart.googleapis.com/chart?cht='.$this->type;
		
		$url .= '&chs='.$this->width.'x'.$this->height;
		$url .= '&chd=t:'.implode(',', $this->datas->toArray());
			
		if(! $this->colors->isEmpty())
			$url .= '&chco='.implode('|', $this->colors->toArray());
		
		if($this->isTransparent())
			$url .= '&chf=bg,s,65432100';
		
		
		if(! $this->labels->isEmpty())
			$url .= '&chl='.implode('|', $this->labels->toArray());
		
		if(! $this->labels->isEmpty())
		{
			$url .= '&chtt='.$this->title;
		
			if($this->labels_options->get('text-align'))
				$url .= '&chdlp='.$this->labels_options->get('text-align');
		
			if($this->labels_options->get('color'))
				$url .= '&chdls='.$this->labels_options->get('color');
			
			if($this->labels_options->get('font-size'))
			{
				if($this->labels_options->get('color'))
					$url .= ','.$this->labels_options->get('font-size');
				else
					$url .= '&chdls=,'.$this->labels_options->get('font-size');
			}
		}
		
		if(!empty($this->title))
		{
			$url .= '&chtt='.$this->title;
			
			/*
			 * Check color
			 */
			if($this->title_options->get('color'))
				$url .= '&chts='.$this->title_options->get('color');
			
			/*
			 * Check font size
			 */
			if($this->title_options->get('font-size'))
			{
				if($this->title_options->get('color'))
					$url .= ','.$this->title_options->get('font-size');
				else
					$url .= '&chts=,'.$this->title_options->get('font-size');
			}
			
			/*
			 * Check alignement
			 */
			if($this->title_options->get('text-align'))
			{
				if($this->title_options->get('color') OR $this->title_options->get('font-size'))
					$url .= ','.$this->title_options->get('text-align');
				else
					$url .= '&chts=,,'.$this->title_options->get('text-align');
			}
			
			if($this->title_options->get('text-align'))
				$url .= '&chts='.$this->title_options->get('text-align');
		}
		
		/*
		 * Margins
		 */
		$url .= '&chma='.implode(',', $this->margins->toArray());
		
		return $url;
	}
	
	/**
	 * @return integer
	 */
	public function getType()
	{
		return $this->type;
	}
	
	/**
	 * @return integer
	 */
	public function getWidth()
	{
		return $this->width;
	}
	
	/**
	 * @param integer $width
	 */
	public function setWidth($width)
	{
		$this->width = (int) $width;
		
		return $this;
	}
	
	/**
	 * @return integer
	 */
	public function getHeight()
	{
		return $this->height;
	}
	
	/**
	 * @param integer $height
	 */
	public function setHeight($height)
	{
		$this->height = (int) $height;
		
		return $this;
	}
	
	/**
	 * @param ArrayCollection $datas
	 */
	public function setDatas(ArrayCollection $datas)
	{
		$this->datas = $datas;
		
		return $this;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getDatas()
	{
		return $this->datas;
	}
	
	/**
	 * @param ArrayCollection $labels
	 */
	public function setLabels(ArrayCollection $labels)
	{
		$this->labels = $labels;
		
		return $this;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getLabels()
	{
		return $this->labels;
	}
	
	/**
	 * @param ArrayCollection $labels_options
	 */
	public function setLabelsOptions(ArrayCollection $labels_options)
	{
		$this->labels_options = $labels_options;
		
		return $this;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getLabelsOptions()
	{
		return $this->$labels_options;
	}
	
	/**
	 * @param ArrayCollection $colors
	 */
	public function setColors(ArrayCollection $colors)
	{
		$this->colors = $colors;
		
		return $this;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getColors()
	{
		return $this->colors;
	}
	
	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}
	
	/**
	 * @param ArrayCollection $options
	 */
	public function setTitleOptions(ArrayCollection $options)
	{
		$this->options = $options;
		
		return $this;
	}
	
	/**
	 * @return ArrayCollection
	 */
	public function getTitleOptions()
	{
		return $this->options;
	}
	
	/**
	 * @param boolean $options
	 */
	public function setTransparency($transparency)
	{
		$this->transparency = (boolean) $transparency;
		
		return $this;
	}
	
	/**
	 * @return boolean
	 */
	public function isTransparent()
	{
		return $this->transparency;
	}
}