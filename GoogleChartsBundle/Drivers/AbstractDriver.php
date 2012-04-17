<?php
namespace Leg\GoogleChartsBundle\Drivers;

use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractDriver
{
	/**
	 * Symfony 2 kernel
	 * @var KernelInterface
	 */
	protected $kernel;
	
	/**
	 * Constructor
	 * @param KernelInterface $kernel
	 */
	function __construct(KernelInterface $kernel)
	{
		$this->kernel = $kernel;	
	}
	
	/**
	 * Import a chart from a file
	 * 
	 * @param string $filename
	 * @return Leg\GoogleChartsBundle\Model\AbstractChart
	 */
	function import($filename)
	{}
}