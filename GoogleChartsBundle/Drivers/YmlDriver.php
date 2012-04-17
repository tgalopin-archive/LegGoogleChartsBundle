<?php
namespace Leg\GoogleChartsBundle\Drivers;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\Yaml\Yaml;

use Leg\GoogleChartsBundle\Drivers\AbstractDriver;

class YmlDriver extends AbstractDriver
{	
	function import($name)
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
				The driver has not found width, height and datas in %s',
				$file
			));
		}
		
		if(	! isset($chartOptions['extends']))
		{
			throw new RuntimeException(sprintf('
				The driver has not found extended chart class in %s',
				$file
			));
		}
		
		if(! class_exists($chartOptions['extends']))
		{
			throw new RuntimeException(sprintf('
				The driver has not found %s in %s',
				$chartOptions['extends'], $file
			));
		}
				
		$chart = new $chartOptions['extends']();
		$chart->setOptions($chartOptions);
		
		return $chart;
	}
}
