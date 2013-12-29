<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle;

use Leg\GCharts\Cache\CacheEngine;
use Leg\GCharts\ChartInterface;
use Leg\GCharts\DataSet\DataSet;
use Leg\GoogleChartsBundle\Drivers\DriverInterface;;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;
use Symfony\Component\HttpKernel\KernelInterface;

class ChartsManager
{
	/**
	 * Loaded drivers
	 * @var DataSet
	 */
	protected $drivers;

	/**
	 * Symfony2 kernel
	 * @var KernelInterface
	 */
	protected $kernel;

	/**
	 * @var boolean
	 */
	protected $cacheEnabled;

	/**
	 * @var CacheEngine
	 */
	protected $cacheEngine;

	/**
	 * @var int
	 */
	protected $defaultKeepTime;

	/**
	 * @param KernelInterface $kernel
	 * @param boolean $cacheEnabled
	 * @param int $defaultKeepTime
	 */
	public function __construct(KernelInterface $kernel, $cacheEnabled, $defaultKeepTime)
	{
		$this->drivers = new DataSet();
		$this->kernel = $kernel;
		$this->cacheEnabled = $cacheEnabled;
		$this->defaultKeepTime = $defaultKeepTime;
	}

	/**
	 * Add a driver to support other file formats
	 *
	 * @param DriverInterface $driver
	 * @return $this
	 */
	public function addDriver(DriverInterface $driver)
	{
		$this->drivers->set(implode('', array_slice(explode('\\', get_class($driver)), -1)), $driver);

		return $this;
	}

	/**
	 * Remove a driver by its name or by its instance
	 *
	 * @param mixed $driver
	 * @return boolean
	 * @throws \InvalidArgumentException
	 */
	public function removeDriver($driver)
	{
		if (is_object($driver) && $driver instanceof DriverInterface)  {
			$driver = implode('', array_slice(explode('\\', get_class($driver)), -1));
		} elseif (is_object($driver)) {
			throw new \InvalidArgumentException(sprintf(
				'Argument 1 passed to '.__CLASS__.'::'.__METHOD__.' must implement DriverInterface.'
			), 500);
		}

		if (! is_string($driver)) {
			throw new \InvalidArgumentException(sprintf(
				'Argument 1 passed to '.__CLASS__.'::'.__METHOD__.' must be a string or an object (%s given).',
				gettype($driver)
			), 500);
		}

		return $this->drivers->remove($driver);
	}

	/**
	 * Gets a driver by its name
	 *
	 * @param string $name
	 * @return DriverInterface
	 */
	public function getDriver($name)
	{
		return $this->drivers->get($name);
	}

	/**
	 * Gets all the loaded drivers
	 * @return DataSet
	 */
	public function getDrivers()
	{
		return $this->drivers;
	}

	/**
	 * Get a chart
	 *
	 * @param string $resource
	 * @return mixed
	 * @throws \RuntimeException
	 */
	public function get($resource)
	{
		/** @var $driver DriverInterface */
		foreach($this->drivers->toArray() as $driver) {
			if ($driver->supports($resource)) {
				return $driver->import($resource);
			}
		}

		throw new \RuntimeException(sprintf(
			'No driver supports the resource "%s".', $resource
		), 500);
	}

	/**
	 * Build a chart. This method is used for cache.
	 *
	 * @param ChartInterface $chart
	 * @param integer        $keepTime
	 * @return mixed
	 */
	public function build(ChartInterface $chart, $keepTime = null)
	{
		if ($this->cacheEnabled && ! $this->cacheEngine) {
			try {
				$assetsUrl = $this->kernel->getContainer()->get('twig')->getExtension('assets')->getAssetUrl('bundles/leg_google_charts').'/';
			} catch(InactiveScopeException $exception) {
				$assetsUrl = '/bundles/leg_google_charts/';
			}

			$this->cacheEngine = new CacheEngine(
				$this->kernel->getRootDir().'/../web/bundles/leg_google_charts',
				$assetsUrl,
				$this->kernel->getRootDir().'/cache/leg_google_charts'
			);
		}

		if ($this->cacheEnabled) {
			if (! is_int($keepTime)) {
				$keepTime = $this->defaultKeepTime;
			}

			return $this->cacheEngine->build($chart, $keepTime);
		}

		return $chart->build();
	}

	/**
	 * Display a chart
	 *
	 * @param string $resource
	 * @return string
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