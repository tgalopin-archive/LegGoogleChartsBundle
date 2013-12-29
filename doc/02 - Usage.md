Using LegGoogleChartsBundle
===========================

To use the main library, see the [library doc](https://github.com/tgalopin/LegGoogleCharts/tree/master/doc).
This documentation is about the bundle itself, and how it is different from the library.

### The ChartManager

To create a chart instance in the bundle, use the same way you would use with the library:

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

		// ...
    }
}
```

However, in the bundle, there is a service called `ChartManager` that manage cache and settings
about your charts. Therefore, to build a chart from the bundle, you have to use this service:

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

See [all the options](https://github.com/tgalopin/LegGoogleCharts/blob/master/doc/03%20-%20Chart%20types.md) from the main documentation.

### External definition files

For more flexibility, you can use an external file to set default options for a chart. It's a file in YML,
XML or PHP which have a defined syntax that the ChartsManager can understand.

**a) Create the file**

All the files must be stored in the "App/YourBundle/Chart" directory to be found by the ChartManager.

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

After that, you can load the file from a controller or directly from Twig.

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

    	// Or $chart = $chartsManager->get('SymfonyMainBundle:ExampleChart.xml');
    	// Or $chart = $chartsManager->get('SymfonyMainBundle:ExampleChart.yml');

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
{# Display the chart directly #}
{{ leg_google_charts_render('SymfonyMainBundle:ExampleChart.php') }}
```

### Next Steps

The following documents are available:

- [04 - Using cache with the CacheEngine](04 - The CacheEngine.md)
- [05 - Avanced usage of LegGoogleChartsBundle](05 - Avanced usage.md)