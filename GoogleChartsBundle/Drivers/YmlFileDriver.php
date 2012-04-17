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
 * YmlFileDriver is the driver to load chart from YAML files.
 * 
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class YmlFileDriver implements DriverInterface
{
	protected $kernel;
	
	public function __construct(KernelInterface $kernel)
	{
		$this->kernel = $kernel;
	}
	
	public function import($resource)
	{
		list($bundleName, $dirName, $fileName) = explode(':', $name);
		
		$bundle = $this->kernel->getBundle($bundleName);
		$file = $bundle->getPath().'/'.$dirName.'/'.$fileName.'.yml';
		
		if(! is_file($file))
		{
			throw new RuntimeException(sprintf('
				The file "%s" does not exist.',
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
				The YAML charts driver has not found width, height or datas in %s',
				$file
			));
		}
		
		if(	! isset($chartOptions['extends']))
		{
			throw new RuntimeException(sprintf('
				The YAML charts driver has not found extended chart class in %s',
				$file
			));
		}
		
		if(! class_exists($chartOptions['extends']))
		{
			throw new RuntimeException(sprintf('
				The YAML charts driver has not found %s in %s',
				$chartOptions['extends'], $file
			));
		}
				
		$chart = new $chartOptions['extends']();
		$chart->setOptions($chartOptions);
		
		return $chart;
	}
	
	public function supports($resource)
	{
		return is_string($resource) && 'yml' === pathinfo($resource, PATHINFO_EXTENSION);
	}
}