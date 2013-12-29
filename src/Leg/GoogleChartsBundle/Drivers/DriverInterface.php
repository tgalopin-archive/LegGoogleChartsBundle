<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Drivers;

use Leg\GCharts\ChartInterface;
use Symfony\Component\HttpKernel\KernelInterface;

interface DriverInterface
{
	/**
	 * Constructor.
	 * @param KernelInterface $kernel
	 */
	public function __construct(KernelInterface $kernel);

	/**
	 * Import a chart from a resource.
	 *
	 * @param string $resource
	 * @return ChartInterface
	 */
	public function import($resource);

	/**
     * Returns true if this class supports the given resource.
     *
     * @param mixed  $resource A resource
     *
     * @return Boolean True if this class supports the given resource, false otherwise
     */
	public function supports($resource);
}