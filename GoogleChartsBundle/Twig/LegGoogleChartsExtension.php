<?php
namespace Leg\GoogleChartsBundle\Twig;

use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\HttpKernel\KernelInterface;

class LegGoogleChartsExtension extends \Twig_Extension
{
	/**
	 * Symfony kernel
	 * @var KernelInterface
	 */
	protected $kernel;
	
	/**
	 * @param KernelInterface $kernel
	 */
	public function __construct(KernelInterface $kernel)
	{
		$this->kernel = $kernel;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Twig_ExtensionInterface::getName()
	 */
	public function getName()
	{
		return 'leg_google_charts';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Twig_Extension::getFunctions()
	 */
	public function getFunctions()
	{
		return array(
			'leg_chart_get' => new \Twig_Function_Method($this, 'get'),
			'leg_chart_render' => new \Twig_Function_Method($this, 'render',
										array('is_safe' => array('html'))),
		);
	}
	
	/**
	 * Get a chart
	 * @param string $menu
	 */
	public function get($name, $driver = 'php')
	{
		$driver = 'Leg\\GoogleChartsBundle\\Drivers\\'.
					ucfirst($driver).'Driver';
		
		if(! class_exists($driver))
		{
			throw new RuntimeException(sprintf('
				%s does not exists.',
				$driver
			));
		}
		
		$driver = new $driver($this->kernel);
		
		return $driver->import($name);
	}
	
	/**
	 * Display a chart
	 * @param string $menu
	 */
	public function render($name, $driver = 'php')
	{
		list($bundleName, $dirName, $className) = explode(':', $name);
		
		$chart = $this->get($name, $driver);

		return '<img src="'.$chart->build().
				'" alt="'.$className.
				'" title="'.$className.
				'" id="'.strtolower($className).
				'" class="chart '.strtolower($chart->getType()).'" />';
	}
}