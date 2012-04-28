Using cache with the CacheEngine
================================

The Google ChartsImage tool is very cool and fast, but for some reason, you may
want to cache the chart images. Fortunately, the LegGoogleChartsBundle provides
a useful CacheEngine to do that for you.

## Enable the CacheEngine

To enable the CacheEngine, you just need to create some configuration in your
config.yml:

``` yml
leg_google_charts:
    cache_engine:
        enabled: true
```

And that's all ! The CacheEngine is now active and by default save each charts
during an hour on your server. You don't need to edit your code.

**Note:**
> By default, the CacheEngine is disabled.

If you want to change the cache duration, you can add this to your config.yml:

``` yml
leg_google_charts:
    cache_engine:
        enabled: true
        default_keep_time: 1500 # In seconds
```

And finally, you can personalise this duration for each chart when it is going
to be created:

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
    	
    														// In seconds
    	$url = $this->get('leg_google_charts')->build($chart, 1500);
    	
        return $this->render('SymfonyMainBundle:Default:index.html.twig', array(
        	'chart_url' => $url
        ));
    }
}
```

## How does it works behind ?

### CacheEngine

The CacheEngine is the base of the system. It has four main methods :

- `put(ChartInterface $chart, $keepTime)`
- `get(ChartInterface $chart)`
- `has(ChartInterface $chart)`
- `clear(ChartInterface $chart)`

The `put()` method build the chart to get the Google URL. It hash this URL in md5
and keep the 10 first characters of this hash. Then it save the chart image from
Google in the public accessible directory `/web/bundles/leg_google_charts` with
as name the hash. After that, it save another file named with the hash in the
public inaccessible directory `/app/cache/leg_google_charts` with as content
the creation time of the chart.

The `get()` method hash the build URL too, and search for files named with this
hash. Its check too if the file is valid and not too old.

The `has()` method check too if the file exists and is valid and not too old.

The `clear()` method delete the cache for a chart.

### Next Steps

The following documents are available:

- [Avanced usage of LegGoogleChartsBundle](internal.md)