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

interface ChartsManagerInterface
{	
	/**
	 * Add a driver to support other file formats
	 * @param DriverInterface $driver
	 */
	public function addDriver(DriverInterface $driver);
	
	/**
	 * Remove a driver by its name or by its instance
	 * @param mixed $driver
	 */
	public function removeDriver($driver);
	
	/**
	 * Gets a driver by its name
	 * @return DriverInterface
	 */
	public function getDriver($name);
	
	/**
	 * Gets all the loaded drivers
	 * @return ArrayCollection
	 */
	public function getDrivers();
	
	/**
	 * Get a chart
	 * @param string $menu
	 */
	public function get($resource);
	
	/**
	 * Display a chart
	 * @param string $menu
	 */
	public function render($resource);
}