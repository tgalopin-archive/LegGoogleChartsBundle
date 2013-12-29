Getting Started With LegGoogleChartsBundle
==========================================

## Installation

Installation is a very quick 2 step process:

1. Download the Bundle
2. Enable the Bundle

### Step 1: Download the Bundle

Ultimately, the LegGoogleChartsBundle files should be downloaded to the
`vendor/leg/googlecharts-bundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony2 method.

**Using composer**

For the moment, you will need to set your `minimum-stability` setting at `alpha`, as the
bundle is not yet stable:

``` json
{
    "require": {
        "leg/googlecharts-bundle": "1.*"
    },
    "minimum-stability": "alpha"
}
```

**Using submodules**

If you prefer instead to use git submodules, the run the following:

``` bash
$ git submodule add git://github.com/tgalopin/LegGoogleChartsBundle.git vendor/leg/googlecharts-bundle
$ git submodule update --init
```

**Using Github**

You can download the bundle with Github, directly or by cloning the repository :

``` bash
git clone git://github.com/tgalopin/LegGoogleChartsBundle.git
```

``` bash
wget https://github.com/tgalopin/LegGoogleChartsBundle/zipball/master
```

And put the directory content in `vendor/leg/googlecharts-bundle`.

#### Step 1.2: Configure the Autoloader

If you didn't use Composer, you need to update your autoloader. To do so,
edit `app/autoload.php` :

``` php
<?php
// app/autoload.php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

$loader->add('Leg\\GCharts', __DIR__.'/../vendor/leg/googlecharts/src');
$loader->add('Leg\\GoogleChartsBundle', __DIR__.'/../vendor/leg/googlecharts-bundle/src');

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
```

### Step 2: Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Leg\GoogleChartsBundle\LegGoogleChartsBundle(),
    );
}
```

### Next Steps

Now that you have completed the basic installation and configuration of the
LegGoogleChartsBundle, you are ready to learn about more advanced features and usages
of the bundle.

The following documents are available:

- [02 - Usage](02 - Usage.md)
- [03 - Cache](03 - Cache.md)