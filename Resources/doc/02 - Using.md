Using LegGoogleChartsBundle
===========================

## Create a chart

Before all, you must choose a chart type: see [the core types](types.md).

To build a chart, you have two ways:

- Using the core gallery
- Using external files

### Using the core gallery
	
You need only to create an instance of a basic chart type, and
customize it:

``` php
<?php
// src/Symfony/MainBundle/Controller/DefaultController

namespace Symfony\MainBundle\Controller;

use Leg\GoogleChartsBundle\Charts\Gallery\BarChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$chart = new BarChart();
    	
    	$chart	->setWidth(200)
		    	->setHeight(200)
		    	->setDatas(array(200, 100, 50));
    	
    	$url = $this->get('leg_google_charts')->build($chart);
    	
        return $this->render('SymfonyMainBundle:Default:index.html.twig', array(
        	'chart_url' => $url
        ));
    }
}
```

See [the core types](types.md) to know more about chart types.
	
### Using external files
	
For more flexibility, you can use a chart file. A chart file is
a file in YML, XML or PHP which have a defined syntax that the ChartsManager
can understand.

**a) Create the file**

You can use:

- PHP:

``` php
<?php
// src/Symfony/MainBundle/Chart/ExampleChart.php

namespace Symfony\MainBundle\Chart;

use Leg\GoogleChartsBundle\Charts\Gallery\BarChart;
	
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

- XML:

``` xml
<?xml version="1.0" encoding="UTF-8" ?>

<parameters>
	<parameter key="height">200</parameter>
	<parameter key="width">200</parameter>
	<parameter key="extends">Leg\GoogleChartsBundle\Charts\Gallery\BarChart</parameter>
	<parameter key="datas">
		<element>200</element>
		<element>100</element>
		<element>50</element>
	</parameter>
</parameters>
```

- YAML:

``` yml
parameters:
    extends: Leg\GoogleChartsBundle\Charts\Gallery\BarChart
    width: 200
    height: 200
    datas: [200, 100, 50]
```

**b) Use the file**

After that creation, you can load the file from a controller or directly from Twig.

- In a Controller:

``` php
<?php
// src/Symfony/MainBundle/Controller/DefaultController

namespace Symfony\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$chartsManager = $this->get('leg_google_charts');
    	
    	$chart = $chartsManager->get('SymfonyMainBundle:ExampleChart.php');
    	
    	/*
    	 * Set datas, labels, ...
    	 */
    	$chart	->setDatas(array(/* ... */))
		    	// ...
		    	->setLabels(array(/* ... */));
    	
        return $this->render('SymfonyMainBundle:Default:index.html.twig', array(
        	'chart_url' => $chartsManager->build($chart)
        ));
    }
}

```

- In a View:

``` twig
{# Only get the chart #}
{% set chart = leg_google_charts_get('SymfonyMainBundle:ExampleChart.php') %}

{{ leg_google_charts_build(chart) }}
```

``` twig
{# Display the chart #}
{{ leg_google_charts_render('SymfonyMainBundle:ExampleChart.php') }}
```

### Next Steps

The following documents are available:

- [03 - Chart types and their properties](03 - Chart types.md)
- [04 - Using cache with the CacheEngine](04 - The CacheEngine.md)
- [05 - Avanced usage of LegGoogleChartsBundle](05 - Avanced usage.md)