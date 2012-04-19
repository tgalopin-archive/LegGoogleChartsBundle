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

use Leg\GoogleChartsBundle\Charts\ChartInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Leg\GoogleChartsBundle\Drivers\DriverInterface;

/**
 * PHPFileDriver is the driver to load chart from PHP files.
 * 
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class PhpFileDriver implements DriverInterface
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
	 * Import a chart from a resource.
	 * 
	 * @param string $resource
	 * @return Leg\GoogleChartsBundle\Charts\ChartInterface
	 */
	public function import($resource)
	{
		$resource = preg_replace('#\.php$#i', '', $resource);
		
		list($bundleName, $className) = explode(':', $resource);
		
		$bundle = $this->kernel->getBundle($bundleName);
		
		$class = $bundle->getNamespace().'\\Chart\\'.$className;
		
		if(! class_exists($class))
		{
			throw new \RuntimeException(sprintf(
				'The PHP charts driver expected class "%s" to be defined in file "%s".
				You probably have a typo in the namespace or the class name.',
				$class, $class.'.php'
			), 500);
		}
		
		$instance = new $class();
		
		if(! $instance instanceof ChartInterface)
		{
			throw new \RuntimeException(sprintf(
				'The class "%s" can not be used as a chart class.',
				$class
			), 500);
		}
		
		return $instance;
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
		return is_string($resource) && 'php' === pathinfo($resource, PATHINFO_EXTENSION);
	}
}