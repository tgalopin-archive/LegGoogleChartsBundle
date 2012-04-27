<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Twig;

use Leg\GoogleChartsBundle\Charts\ChartInterface;

use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\HttpKernel\KernelInterface;

use Leg\GoogleChartsBundle\Charts\ChartsManagerInterface;

class LegGoogleChartsExtension extends \Twig_Extension
{
	/**
	 * Charts manager
	 * @var ChartsManager
	 */
	protected $charts_manager;
	
	/**
	 * @param ChartsManagerInterface $charts_manager
	 */
	public function __construct(ChartsManagerInterface $charts_manager)
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
			'leg_google_charts_build' => new \Twig_Function_Method($this, 'build',
										array('is_safe' => array('html'))),
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
	public function build(ChartInterface $chart)
	{
		return $this->charts_manager->build($chart);
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