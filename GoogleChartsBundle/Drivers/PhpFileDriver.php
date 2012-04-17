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

use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Leg\GoogleChartsBundle\Drivers\DriverInterface;

/**
 * PHPFileDriver is the driver to load chart from PHP files.
 * 
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class PhpFileDriver implements DriverInterface
{
	protected $kernel;
	
	public function __construct(KernelInterface $kernel)
	{
		$this->kernel = $kernel;
	}
	
	public function import($resource)
	{
		list($bundleName, $className) = explode(':', $resource);
		
		$bundle = $this->kernel->getBundle($bundleName);
		
		$class = $bundle->getNamespace().'\\Chart\\'.$className;
		
		if(! class_exists($class))
		{
			throw new RuntimeException(sprintf('
				The PHP charts driver expected class "%s" to be defined in file "%s".
				You probably have a typo in the namespace or the class name.',
				$class, $class.'.php'
			));
		}
		
		return new $class();
	}
	
	public function supports($resource)
	{
		return is_string($resource) && 'php' === pathinfo($resource, PATHINFO_EXTENSION);
	}
}