<?php
namespace Leg\GoogleChartsBundle\Drivers;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\DependencyInjection\Exception\RuntimeException;

use Leg\GoogleChartsBundle\Drivers\AbstractDriver;

class XmlDriver extends AbstractDriver
{	
	function import($name)
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
				The driver has not found "%s" in "%s"',
				$extends, $file
			));
		}
		
		$chart = new $extends();
		$chart->setOptions($options);

		return $chart;
	}
}
