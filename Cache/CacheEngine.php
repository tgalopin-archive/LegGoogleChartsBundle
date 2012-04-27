<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Cache;

use Leg\GoogleChartsBundle\Charts\ChartInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;

/**
 * CacheEngine is an engine to cache the charts.
 */
class CacheEngine
{	
	/**
	 * Public cache directory (accessible from users)
	 * @var string
	 */
	protected $public_cache_dir;
	
	/**
	 * Internal cache directory (hidden to users)
	 * @var string
	 */
	protected $internal_cache_dir;
	
	/**
	 * Public cache directory (accessible from users) in asset version
	 * @var string
	 */
	protected $asset_cache_dir;
	
	/**
	 * @param KernelInterface $kernel
	 */
	public function __construct(KernelInterface $kernel)
	{
		$this->public_cache_dir = $kernel->getRootDir().'/../web/bundles/leg_google_charts';
		$this->internal_cache_dir = $kernel->getRootDir().'/cache/leg_google_charts';
		
		try
		{
			$this->asset_cache_dir = $kernel->getContainer()
											->get('twig')
											->getExtension('assets')
											->getAssetUrl('bundles/leg_google_charts');
		}
		catch(InactiveScopeException $exception)
		{}
	}
	
	/**
	 * Boot the cache engine :
	 * 		Create the directories that are needed
	 */
	public function boot()
	{
		$this->createTree($this->public_cache_dir);
		$this->createTree($this->internal_cache_dir);
	}
	
	/**
	 * Save a chart during a given time in the cache.
	 * 
	 * @param ChartInterface $chart
	 * @param integer $keepTime
	 */
	public function put(ChartInterface $chart, $keepTime)
	{		
		$filename = $this->hash($chart->_build());
		
		file_put_contents(
			$this->getInternalCacheDir().'/'.$filename.'.meta',
			time() + $keepTime
		);
		
		file_put_contents(
			$this->getPublicCacheDir().'/'.$filename.'.png',
			file_get_contents($chart->_build())
		);
	}
	
	/**
	 * Clear the cache for the given chart.
	 *
	 * @param ChartInterface $chart
	 */
	public function clear(ChartInterface $chart)
	{
		$filename = $this->hash($chart->_build());
		
		$internalCacheFile = $this->getInternalCacheDir().'/'.$filename.'.meta';
		$publicCacheFile = $this->getPublicCacheDir().'/'.$filename.'.png';
		
		if(file_exists($internalCacheFile))
			unlink($internalCacheFile);
		
		if(file_exists($publicCacheFile))
			unlink($publicCacheFile);
	}
	
	/**
	 * Check if the chart is in cache or not.
	 *
	 * @param ChartInterface $chart
	 */
	public function has(ChartInterface $chart)
	{
		$filename = $this->hash($chart->_build());
		$internalCacheFile = $this->getInternalCacheDir().'/'.$filename.'.meta';
		$hasFile = false;
		
		if(file_exists($internalCacheFile))
		{
			$chartKeepTime = file_get_contents($internalCacheFile);
			
			if($chartKeepTime < time())
			{
				unlink($internalCacheFile);
				unlink($this->getPublicCacheDir().'/'.$filename.'.png');
			}
			else
			{
				$hasFile = true;
			}
		}
		
		return $hasFile;
	}
	
	/**
	 * Get a chart in the cache if it's possible or directly on Google else.
	 *
	 * @param ChartInterface $chart
	 */
	public function get(ChartInterface $chart)
	{
		if(! $this->has($chart))
			return $chart->_build();
		
		return $this->getAssetCacheDir().'/'.$this->hash($chart->_build()).'.png';
	}
	
	/**
	 * Clear all the cache, for all charts.
	 */
	public function clearAll()
	{
		// Images
		$iterator = new \DirectoryIterator($this->getPublicCacheDir());
		
		foreach($iterator as $file)
		{
			if($file->isFile())
				unlink($file->getPathname());
		}
		
		// Metadatas
		$iterator = new \DirectoryIterator($this->getInternalCacheDir());
		
		foreach($iterator as $file)
		{
			if($file->isFile())
				unlink($file->getPathname());
		}
	}
	
	/**
	 * Gets the public cache directory
	 * @return string
	 */
	public function getPublicCacheDir()
	{
	    return $this->public_cache_dir;
	}
	
	/**
	 * Gets the internal cache directory
	 * @return string
	 */
	public function getInternalCacheDir()
	{
	    return $this->internal_cache_dir;
	}
	
	/**
	 * Gets the public cache directory in asset version
	 * @return string
	 */
	public function getAssetCacheDir()
	{
	    return $this->asset_cache_dir;
	}
	
	/**
	 * Sets the public cache directory
	 * @param $public_cache_dir string
	 */
	public function setPublicCacheDir($public_cache_dir)
	{
	    $this->public_cache_dir = (string) $public_cache_dir;
	}
	
	/**
	 * Sets the internal cache directory
	 * @param $internal_cache_dir string
	 */
	public function setInternalCacheDir($internal_cache_dir)
	{
	    $this->internal_cache_dir = (string) $internal_cache_dir;
	}
	
	/**
	 * Sets the public cache directory in asset version
	 * @param $asset_cache_dir string
	 */
	public function setAssetCacheDir($asset_cache_dir)
	{
	    $this->asset_cache_dir = (string) $asset_cache_dir;
	}
	
	/**
	 * Create a directory with its parents recursively
	 * @param string $dirname
	 */
	private function createTree($dirname)
	{
		if(! file_exists($dirname))
			mkdir($dirname, 0777, true);
	}
	
	/**
	 * Hash the URL to return a unique file name
	 * @param string $url
	 */
	private function hash($url)
	{
		return substr(md5($url), 0, 10);
	}
}