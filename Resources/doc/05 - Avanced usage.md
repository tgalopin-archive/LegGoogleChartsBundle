Avanced usage of LegGoogleChartsBundle
======================================

## Create your own chart type

LegGoogleChartsBundle is based on a complete gallery for the GoogleChartsImages
tool. However, you may need to extends this gallery and make your own chart type.
It's simple.

In the bundle, all the types are stored in a directory named `Charts`. The most
basic chart (`BaseChart.php`) have all what you need, but you can extends others 
charts like `BarChart`.

In your bundle, you just need to create a chart file like this :

``` php
<?php
// src/Symfony/MainBundle/Charts/Gallery/MyChart.php

namespace Symfony\MainBundle\Charts\Gallery;

use Leg\GoogleChartsBundle\Charts\BaseChart;

class MyChart extends BaseChart
{
	public function __construct()
	{
		parent::__construct();
		
		// ...
	}
	
	// ...
}
```

As you can see, a chart type is a simple class that extends another chart type.

**Note:**
> If you don't want to extends another chart type, there is only one requirement:
> your chart type class **must** implements `Leg\GoogleChartsBundle\Charts\ChartInterface`.

After that, you can use your new chart type like all the others:

``` php
<?php
// src/Symfony/MainBundle/Controller/DefaultController

namespace Symfony\MainBundle\Controller;

use Symfony\MainBundle\Charts\Gallery\MyChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$chart = new MyChart();
    	
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

## Create your own chart driver

LegGoogleChartsBundle provides by default some drivers that are used to 
translate files in charts. There is in the core three drivers:

- `PhpFileDriver` that understand PHP
- `XmlFileDriver` that understand XML
- `YmlFileDriver` that understand YAML

You may need/want to use another format: you can do that very easily.

All the LegGoogleChartsBundle drivers are stored in the directory `Drivers` and
are loaded by the `ChartsDriversCompilerPass`. So there are all services with the
tag `leg_google_charts.driver`, as you can see in `Resources/config/services.xml`.

To add your own driver, you just need to create a service named as you want with
the tag `leg_google_charts.driver`. This service **must** implements the interface
`Leg\GoogleChartsBundle\Drivers\DriverInterface`.

**Note:**
> As you can see in this interface, all the driver can access to the kernel
> with the properties `$this->kernel`. That means too you need pass as argument
> the kernel to the driver service.

For instance, the `PhpFileDriver` is loaded by this definition:

``` xml
<service id="leg_google_charts.driver.php" class="%leg_google_charts.driver.php.class%">
    <argument type="service" id="kernel" />
    <tag name="leg_google_charts.driver" />
</service>
```

And look like:

``` php
<?php
// vendor/bundles/Leg/GoogleChartsBundle/Drivers/PhpFileDriver.php

namespace Leg\GoogleChartsBundle\Drivers;

use Leg\GoogleChartsBundle\Charts\ChartInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Leg\GoogleChartsBundle\Drivers\DriverInterface;

/**
 * PHPFileDriver is the driver to load chart from PHP files.
 * 
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class PhpFileDriver implements DriverInterface
{
	/**
	 * Kernel
	 * @var KernelInterface
	 */
	protected $kernel;
	
	/**
	 * Constructor.
	 * @param KernelInterface $kernel
	 */
	public function __construct(KernelInterface $kernel)
	{
		$this->kernel = $kernel;
	}
	
	/**
	 * Import a chart from a resource.
	 * 
	 * @param string $resource
	 * @return Leg\GoogleChartsBundle\Charts\ChartInterface
	 */
	public function import($resource)
	{
		$resource = preg_replace('#\.php$#i', '', $resource);
		
		list($bundleName, $className) = explode(':', $resource);
		
		$bundle = $this->kernel->getBundle($bundleName);
		
		$class = $bundle->getNamespace().'\\Chart\\'.$className;
		
		if(! class_exists($class))
		{
			throw new \RuntimeException(sprintf(
				'The PHP charts driver expected class "%s" to be defined in file "%s".
				You probably have a typo in the namespace or the class name.',
				$class, $class.'.php'
			), 500);
		}
		
		$instance = new $class();
		
		if(! $instance instanceof ChartInterface)
		{
			throw new \RuntimeException(sprintf(
				'The class "%s" can not be used as a chart class.',
				$class
			), 500);
		}
		
		return $instance;
	}
	
	/**
	 * Returns true if this class supports the given resource.
	 *
	 * @param mixed  $resource A resource
	 *
	 * @return Boolean True if this class supports the given resource, false otherwise
	 */
	public function supports($resource)
	{
		return is_string($resource) && 'php' === pathinfo($resource, PATHINFO_EXTENSION);
	}
}
```

The `import($resource)` method is used by the ChartsManager to load the resource
(the resource is in fact the given name, like `SymfonyMainBundle:ExampleChart.php`).
The `supports($resource)` method is used by the ChartsManager to find which driver
can understand the resource.

**Note:**
> If two drivers or more can read a file, the first added is used.

**Note:**
> If no driver can read a file, an exception will be sent.

**Caution:**
> The ChartsManager store the driver by their name, so if you name two drivers
> similar, even in different directories, the second will erase the first. That
> can be interesting to overwrite the core drivers.