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
 * XmlFileDriver is the driver to load chart from XML files.
 * 
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class XmlFileDriver implements DriverInterface
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
		$file = $bundle->getPath().'/'.$dirName.'/'.$fileName.'.xml';
		
		if(! is_file($file))
		{
			throw new RuntimeException(sprintf('
				The file "%s" does not exist.',
				$file
			));
		}
		
		$xmlDocument = new \SimpleXMLElement($file, null, true);
		
		$options = array();
		$extends = '';
		
		foreach($xmlDocument->children() as $child)
		{
			if($child->count() > 0)
			{
				$children = (array) $child->children();
				
				$options[(string) $child['key']] = $children['element'];
			}
			else
			{
				if($child['key'] == 'extends')
				{
					$extends = (string) $child;
				}
				else
				{
					$options[(string) $child['key']] = (string) $child;
				}
			}
		}
		
		if(empty($extends) OR ! class_exists($extends))
		{
			throw new RuntimeException(sprintf('
				The XML charts driver has not found "%s" in "%s"',
				$extends, $file
			));
		}
		
		$chart = new $extends();
		$chart->setOptions($options);

		return $chart;
	}
	
	public function supports($resource)
	{
		return is_string($resource) && 'php' === pathinfo($resource, PATHINFO_EXTENSION);
	}
}