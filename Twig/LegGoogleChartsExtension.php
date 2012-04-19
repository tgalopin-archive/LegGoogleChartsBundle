<?php
namespace Leg\GoogleChartsBundle\Twig;

use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\HttpKernel\KernelInterface;

use Leg\GoogleChartsBundle\Charts\ChartsManager;

class LegGoogleChartsExtension extends \Twig_Extension
{
	/**
	 * Charts manager
	 * @var ChartsManager
	 */
	protected $charts_manager;
	
	/**
	 * @param ChartsManager $charts_manager
	 */
	public function __construct(ChartsManager $charts_manager)
	{
		$this->charts_manager = $charts_manager;
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
			'leg_google_charts_get' => new \Twig_Function_Method($this, 'get'),
			'leg_google_charts_render' => new \Twig_Function_Method($this, 'render',
										array('is_safe' => array('html'))),
		);
	}
	
	/**
	 * Get a chart
	 * @param string $menu
	 */
	public function get($name)
	{
		return $this->charts_manager->get($name);
	}
	
	/**
	 * Display a chart
	 * @param string $menu
	 */
	public function render($name)
	{
		return $this->charts_manager->render($name);
	}
}