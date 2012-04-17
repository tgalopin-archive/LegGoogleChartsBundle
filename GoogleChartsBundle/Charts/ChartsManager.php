<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Charts;

use Leg\GoogleChartsBundle\Drivers\DriverInterface;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpKernel\KernelInterface;

class ChartsManager
{
	/**
	 * Loaded drivers
	 * @var ArrayCollection
	 */
	protected $drivers;
	
	/**
	 * @param KernelInterface $kernel
	 */
	public function __construct()
	{
		$this->drivers = new ArrayCollection();
	}
	
	/**
	 * Add a driver to support other file formats
	 * @param DriverInterface $driver
	 */
	public function addDriver(DriverInterface $driver)
	{
		$this->drivers->add($driver);
	}
	
	/**
	 * Get a chart
	 * @param string $menu
	 */
	public function get($resource)
	{		
		foreach($this->drivers as $driver)
		{
			if($driver->supports($resource))
				return $driver->import($resource);
		}
		
		throw new \RuntimeException(sprintf(
			'No driver supports the resource "%s".', $resource
		), 500);
	}
	
	/**
	 * Display a chart
	 * @param string $menu
	 */
	public function render($resource)
	{
		$chart = $this->get($resource);

		return '<img src="'.$chart->build().
				'" alt="'.$resource.
				'" title="'.$resource.
				'" id="'.strtolower($resource).
				'" class="chart '.strtolower($chart->getType()).'" />';
	}
}