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
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * YmlFileDriver is the driver to load chart from YAML files.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class YmlFileDriver implements DriverInterface
{
	/**
	 * Kernel
	 * @var KernelInterface
	 */
	protected $kernel;

	/**
	 * Constructor.
	 * @param KernelInterface $kernel
	 */
	public function __construct(KernelInterface $kernel)
	{
		$this->kernel = $kernel;
	}

	/**
	 * @param string $resource
	 * @return ChartInterface
	 * @throws \RuntimeException
	 * @throws \InvalidArgumentException
	 */
	public function import($resource)
	{
		list($bundleName, $fileName) = explode(':', $resource);

		$bundle = $this->kernel->getBundle($bundleName);
		$file = $bundle->getPath().'/Chart/'.$fileName;

		if (! is_file($file)) {
			throw new \InvalidArgumentException(sprintf(
				'The file "%s" does not exist.',
				$fileName
			), 500);
		}

		$yamlParser = new Yaml();
		$chartOptions = $yamlParser->parse($file);
		$chartOptions = $chartOptions['parameters'];

		if (! isset($chartOptions['extends'])) {
			throw new \RuntimeException(sprintf(
				'The YAML charts driver has not found extended chart class in "%s"',
				$fileName
			), 500);
		}

		if (! class_exists($chartOptions['extends'])) {
			throw new \RuntimeException(sprintf(
				'The YAML charts driver has not found %s in "%s"',
				$chartOptions['extends'], $fileName
			), 500);
		}

		$chart = new $chartOptions['extends']();
		unset($chartOptions['extends']);
		$chart->setOptions($chartOptions);

		return $chart;
	}

	/**
	 * Returns true if this class supports the given resource.
	 *
	 * @param mixed  $resource A resource
	 *
	 * @return Boolean True if this class supports the given resource, false otherwise
	 */
	public function supports($resource)
	{
		return is_string($resource) && 'yml' === pathinfo($resource, PATHINFO_EXTENSION);
	}
}