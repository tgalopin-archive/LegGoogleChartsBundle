Use GoogleChartsBundle
======================

Before all, you must choose a chart type : see types.md

To build a chart, you have two ways :
	- with the basic classes
	- extending the basic classes

*********************************
* Method 1) Using basic classes
*********************************
	
	You need only to create an instance of a basic chart type, and
	customize it :

	``` php
	<?php
	// src/Acme/FooBundle/Controller/DefaultController.php
	
	namespace Acme\FooBundle\Controller;
	
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Leg\GoogleChartsBundle\Charts\BarChart;
	
	class DefaultController extends Controller
	{
	    public function indexAction()
	    {
	    	$chart = new BarChart();
	    	
	    	$chart	->setWidth(200)
	    			->setHeight(200)
	    			->setDatas(array(200, 100, 50));
	    	
	        return $this->render('AcmeFooBundle:Default:index.html.twig',
	        		array('chart' => $chart));
	    }
	}
	```
	
	See types.md to know more about chart types.
	
*********************************
* Method 2) Using chart files
*********************************
	
	For more flexibility, you can use a chart file. A chart file is
	a file in YML, XML or PHP (you can add your own extensions : see
	internal.md) which have a defined syntax.
	
	#####
	## Create the file
	#####
	
	--------- In PHP

	``` php
	<?php
	// src/Acme/FooBundle/Chart/ExampleChart.php
	
	namespace Acme\FooBundle\Chart;
	
	use Leg\GoogleChartsBundle\Charts\BarChart;
	
	class ExampleChart extends BarChart
	{		
		public function getDefaultOptions()
		{
			return array(
				'width' => 200,
				'height' => 200,
				'datas' => array(100, 75, 45)
			);
		}
	}
	```
	
	--------- In XML
	
	``` xml
	<?xml version="1.0" encoding="UTF-8" ?>
	
	<parameters>
		<parameter key="height">200</parameter>
		<parameter key="width">200</parameter>
		<parameter key="extends">Leg\GoogleChartsBundle\Charts\BarChart</parameter>
		<parameter key="datas">
			<element>200</element>
			<element>100</element>
			<element>50</element>
		</parameter>
	</parameters>
	```
	
	--------- In YML
	
	``` yml
	parameters:
	    extends: Leg\GoogleChartsBundle\Charts\BarChart
	    width: 200
	    height: 200
	    datas: [200, 100, 50]
	```
	
	#####
	## Get the file
	#####
	
	After that creation, you can simply use the file in two ways :
		- from a controller
		- directly from Twig
	
	--------- In a Controller
	
	``` php
	<?php
	namespace Acme\FooBundle\Controller;
	
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Leg\GoogleChartsBundle\Charts\BarChart;
	
	class DefaultController extends Controller
	{
	    public function indexAction()
	    {
	    	/*
	    	 * Get the charts manager : leg_charts is a service
	    	 */
	    	$chartManager = $this->get('leg_charts');
	    	
	    	/*
	    	 * Get a chart with the chart file
	    	 */
	    	$chart = $chartManager->get('AcmeFooBundle:Chart:ExampleChart',
	    								'xml');
			
	    	/*
	    	 * Set datas, labels, ...
	    	 */
	    	$chart	->setDatas(array(/* ... */))
	    			// ...
	    			->setLabels(array(/* ... */));
			
	    	/*
	    	 * Build the URI
	    	 */
	    	$url = $chart->build();
	    	
	        return $this->render('AcmeFooBundle:Default:index.html.twig',
	        		array('chartUri' => $url));
	    }
	}
	```
	
	--------- In a View
	
	``` twig
	{# Only get the chart #}
	{{ leg_chart_get('AcmeFooBundle:Chart:ExampleChart', 'xml') }}
	
	{# Display the chart #}
	{{ leg_chart_render('AcmeFooBundle:Chart:ExampleChart', 'xml') }}
	```
	
	Of course, you can change driver, by change 'xml' with 'yml' or 'php'.
	
	
	