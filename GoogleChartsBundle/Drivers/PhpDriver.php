<?php
namespace Leg\GoogleChartsBundle\Drivers;

use Symfony\Component\DependencyInjection\Exception\RuntimeException;

use Leg\GoogleChartsBundle\Drivers\AbstractDriver;

class PhpDriver extends AbstractDriver
{	
	function import($name)
	{
		list($bundleName, $dirName, $className) = explode(':', $name);
		
		$bundle = $this->kernel->getBundle($bundleName);
		
		$class = $bundle->getNamespace().'\\'.$dirName.'\\'.$className;
		
		if(! class_exists($class))
		{
			throw new RuntimeException(sprintf('
				The autoloader expected class "%s" to be defined in file "%s".
				You probably have a typo in the namespace or the class name.',
				$class, $class.'.php'
			));
		}
		
		return new $class();
	}
}