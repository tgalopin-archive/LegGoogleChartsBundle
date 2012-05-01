<?php

/*
 * This file is part of the LegGoogleChartsBundle package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leg\GoogleChartsBundle\Tests\Cache;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Leg\GoogleChartsBundle\Charts\Gallery\PieChart;
use Leg\GoogleChartsBundle\Charts\Gallery\BarChart;
use Leg\GoogleChartsBundle\Cache\CacheEngine;

/**
 * CacheEngine is an engine to cache the charts.
 */
class CacheEngineTest extends WebTestCase
{	
	public function testCreate()
	{
		$kernel = new \AppKernel('dev', true);
		$kernel->boot();
		
		$cacheEngine = new CacheEngine($kernel);
		
		$this->assertGreaterThan(0, strlen($cacheEngine->getInternalCacheDir()));
		$this->assertGreaterThan(0, strlen($cacheEngine->getPublicCacheDir()));
		
		$cacheEngine->setPublicCacheDir($kernel->getRootDir().'/web/bundles/leg_google_charts');
		$cacheEngine->setInternalCacheDir($kernel->getRootDir().'/cache/leg_google_charts');
		$cacheEngine->setAssetCacheDir('/web/bundles/leg_google_charts');
		
		$this->assertGreaterThan(0, strlen($cacheEngine->getAssetCacheDir()));
		
		$cacheEngine->boot();
		
		$this->assertTrue(file_exists($cacheEngine->getPublicCacheDir()));
		$this->assertTrue(file_exists($cacheEngine->getInternalCacheDir()));
		
		return $cacheEngine;
	}
	
	/**
	 * @depends testCreate
	 */
	public function testPut(CacheEngine $cacheEngine)
	{
		$chart = new BarChart();
		
		$chart->setDatas(array(152, 142, 12));
		$chart->setWidth(200);
		$chart->setHeight(200);
		$chart->setAxis(array('x', 'y'));
		
		@$cacheEngine->put($chart, 1200);
		
		$this->assertTrue(file_exists($cacheEngine->getInternalCacheDir().'/61aabe7880.meta'));
		
		return $cacheEngine;
	}
	
	/**
	 * @depends testPut
	 */
	public function testHasAndGet(CacheEngine $cacheEngine)
	{
		$chart = new BarChart();
		
		$chart->setDatas(array(152, 142, 12));
		$chart->setWidth(200);
		$chart->setHeight(200);
		$chart->setAxis(array('x', 'y'));
		
		$this->assertTrue($cacheEngine->has($chart));
		$this->assertTrue(is_string($cacheEngine->get($chart)));
		$this->assertGreaterThan(0, strlen($cacheEngine->get($chart)));
	}
	
	/**
	 * @depends testCreate
	 */
	public function testClear(CacheEngine $cacheEngine)
	{
		$chart = new BarChart();
		
		$chart->setDatas(array(152, 142, 12));
		$chart->setWidth(200);
		$chart->setHeight(200);
		$chart->setAxis(array('x', 'y'));
		
		@$cacheEngine->put($chart, 1200);
		$cacheEngine->clear($chart);
		
		$this->assertTrue(! $cacheEngine->has($chart));
		
		$chart = new PieChart();
		
		$chart->setDatas(array(152, 142, 12));
		$chart->setWidth(200);
		$chart->setHeight(200);
		
		@$cacheEngine->put($chart, 1200);
		$cacheEngine->clearAll();
		
		$this->assertTrue(! $cacheEngine->has($chart));
	}
}