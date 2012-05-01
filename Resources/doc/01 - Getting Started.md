Getting Started With LegGoogleChartsBundle
==========================================

Developpers can used easily the Google Charts Image project from Google by using
GET requests. However, this requests are not really convenient, and this bundle
provides an API in PHP to generate them. It helps you too to 
define simply charts models, etc. 

## Installation

Installation is a very quick 3 step process:

1. Download the Bundle
2. Configure the Autoloader
3. Enable the Bundle

### Step 1: Download the Bundle

Ultimately, the LegGoogleChartsBundle files should be downloaded to the
`vendor/bundles/Leg/GoogleChartsBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony2 method.

**Using the vendors script**

Add the following lines in your `deps` file:

```
[LegGoogleChartsBundle]
    git=git://github.com/tgalopin/LegGoogleChartsBundle.git
    target=bundles/Leg/GoogleChartsBundle
```

Now, run the vendors script to download the bundle:

``` bash
$ php bin/vendors install
```

**Using submodules**

If you prefer instead to use git submodules, the run the following:

``` bash
$ git submodule add git://github.com/tgalopin/LegGoogleChartsBundle.git vendor/bundles/Leg/GoogleChartsBundle
$ git submodule update --init
```

**Using composer**

If you prefer instead to use composer, use this lines:

``` json
{
    "require": {
        "leg/googlecharts-bundle": "*"
    }
}
```

**Using Github**

You can download the bundle with Github, directly or by cloning the repository :

``` bash
git clone git://github.com/tgalopin/LegGoogleChartsBundle.git
```

``` bash
wget https://github.com/tgalopin/LegGoogleChartsBundle/zipball/master
```

And put the directory content in `vendor/bundles/Leg/GoogleChartsBundle`.

### Step 2: Configure the Autoloader

Add the `Leg` namespace to your autoloader:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'Leg' => __DIR__.'/../vendor/bundles',
));
```

### Step 3: Enable the bundle

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

- [02 - Using the charts](02 - Using.md)
- [03 - Chart types and their properties](03 - Chart types.md)
- [04 - Using cache with the CacheEngine](04 - The CacheEngine.md)
- [05 - Avanced usage of LegGoogleChartsBundle](05 - Avanced usage.md)
