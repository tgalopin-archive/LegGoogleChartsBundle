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

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

use Leg\GoogleChartsBundle\Drivers\DriverInterface;

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
	 * Import a chart from a resource.
	 * 
	 * @param string $resource
	 * @return Leg\GoogleChartsBundle\Charts\ChartInterface
	 */
	public function import($resource)
	{
		list($bundleName, $fileName) = explode(':', $resource);
		
		$bundle = $this->kernel->getBundle($bundleName);
		$file = $bundle->getPath().'/Chart/'.$fileName;
		
		if(! is_file($file))
		{
			throw new RuntimeException(sprintf(
				'The file "%s" does not exist.',
				$file
			));
		}
		
		$yamlParser = new Yaml();
		$chartOptions = $yamlParser->parse($file);
		$chartOptions = $chartOptions['parameters'];
		
		if(	! isset($chartOptions['width'])
			OR ! isset($chartOptions['height'])
			OR ! isset($chartOptions['datas']))
		{
			throw new RuntimeException(sprintf('
				The YAML charts driver has not found width, height or datas in "%s"',
				$file
			));
		}
		
		if(	! isset($chartOptions['extends']))
		{
			throw new RuntimeException(sprintf('
				The YAML charts driver has not found extended chart class in "%s"',
				$file
			));
		}
		
		if(! class_exists($chartOptions['extends']))
		{
			throw new RuntimeException(sprintf('
				The YAML charts driver has not found %s in "%s"',
				$chartOptions['extends'], $file
			));
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