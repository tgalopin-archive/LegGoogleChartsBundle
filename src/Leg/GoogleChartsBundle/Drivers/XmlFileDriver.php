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

/**
 * XmlFileDriver is the driver to load chart from XML files.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class XmlFileDriver implements DriverInterface
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

		$xmlDocument = new \SimpleXMLElement($file, null, true);

		$options = array();
		$extends = '';

		foreach ($xmlDocument->children() as $child) {
			if ($child->count() > 0) {
				$children = (array) $child->children();
				$options[(string) $child['key']] = $children['element'];
			} else {
				if ($child['key'] == 'extends') {
					$extends = (string) $child;
				} else {
					$options[(string) $child['key']] = (string) $child;
				}
			}
		}

		if (empty($extends)) {
			throw new \RuntimeException(sprintf(
				'The XML charts driver has not found extended chart class in "%s"',
				$fileName
			), 500);
		}

		if (! class_exists($extends)) {
			throw new \RuntimeException(sprintf(
				'The XML charts driver has not found %s in "%s"',
				$extends, $fileName
			), 500);
		}

		$chart = new $extends();
		$chart->setOptions($options);

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
		return is_string($resource) && 'xml' === pathinfo($resource, PATHINFO_EXTENSION);
	}
}