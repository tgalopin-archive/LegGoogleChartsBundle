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

class ChartsManager implements ChartsManagerInterface
{
	/**
	 * Loaded drivers
	 * @var ArrayCollection
	 */
	protected $drivers;
	
	/**
	 * Symfony2 kernel
	 * @var KernelInterface
	 */
	protected $kernel;
	
	/**
	 * @param KernelInterface $kernel
	 */
	public function __construct(KernelInterface $kernel)
	{
		$this->drivers = new ArrayCollection();
		$this->kernel = $kernel;
	}
	
	/**
	 * Add a driver to support other file formats
	 * @param DriverInterface $driver
	 */
	public function addDriver(DriverInterface $driver)
	{
		return $this->drivers->set(
			implode('', array_slice(explode('\\', get_class($driver)), -1)),
			$driver
		);
	}
	
	/**
	 * Remove a driver by its name or by its instance
	 * @param mixed $driver
	 */
	public function removeDriver($driver)
	{
		if(is_object($driver) && $driver instanceof DriverInterface)
		{
			$driver = implode('', array_slice(explode('\\', get_class($driver)), -1));
		}
		elseif(is_object($driver))
		{
			throw new \InvalidArgumentException(sprintf(
				'Argument 1 passed to '.__CLASS__.'::'.__METHOD__.' must implement DriverInterface.'
			), 500);
		}
		
		if(! is_string($driver))
		{
			throw new \InvalidArgumentException(sprintf(
				'Argument 1 passed to '.__CLASS__.'::'.__METHOD__.' must be a string or an object (%s given).',
				gettype($driver)
			), 500);
		}
		
		return $this->drivers->remove($driver);
	}
	
	/**
	 * Gets a driver by its name
	 * @return DriverInterface
	 */
	public function getDriver($name)
	{
		return $this->drivers->get($name);
	}
	
	/**
	 * Gets all the loaded drivers
	 * @return ArrayCollection
	 */
	public function getDrivers()
	{
		return $this->drivers;
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
	 * Build a chart. This method is used for cache.
	 * @param ChartInterface $chart
	 */
	public function build(ChartInterface $chart, $keepTime = null)
	{
		$cacheEngineIsEnabled = $this->kernel->getContainer()->getParameter(
			'leg_google_charts.cache_engine.enabled'
		);
		
		if($cacheEngineIsEnabled)
		{
			$defaultKeepTime = $this->kernel->getContainer()->getParameter(
				'leg_google_charts.cache_engine.default_keep_time'
			);
			
			if(! is_int($keepTime))
				$keepTime = $defaultKeepTime;
			
			$cacheEngine = $this->kernel->getContainer()
										->get('leg_google_charts.cache_engine');
			
			$cacheEngine->boot();
			
			if(! $cacheEngine->has($chart))
				$cacheEngine->put($chart, $keepTime);
			
			return $cacheEngine->get($chart);
		}
		
		return $chart->_build();
	}
	
	/**
	 * Display a chart
	 * @param string $menu
	 */
	public function render($resource)
	{
		$chart = $this->get($resource);

		return '<img src="'.$this->build($chart).
				'" alt="'.$resource.
				'" title="'.$resource.
				'" id="'.strtolower($resource).
				'" class="chart '.strtolower($chart->getType()).'" />';
	}
}