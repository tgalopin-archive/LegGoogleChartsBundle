README
======

What is LegGoogleChartsBundle ?
-----------------

LegGoogleChartsBundle is a bundle for the PHP 5.3 framework Symfony2.
It allows developers to use easily the Google Charts API with PHP classes.

Requirements
------------

This bundle require Symfony2.X.X

Installation
------------

### Step 1: Download the bundle

You can download the bundle with Github, directly or by cloning the repository :

```git
git://github.com/tgalopin/LegGoogleChartsBundle.git
```

```git
https://github.com/tgalopin/LegGoogleChartsBundle/zipball/master
```

And put the "Leg" directory in "vendor/bundles".

### Step 2: Enable the bundle

Add the following namespace entry to the `registerNamespaces` call
in your autoloader

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'Leg' => __DIR__.'/../vendor/bundles',
    // ...
));
```

Then, register the bundle in your AppKernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Leg\GoogleChartsBundle\LegGoogleChartsBundle(),
    );
    // ...
)
```

Documentation
-------------

To read the documentation, go to :

1. http://titouangalopin.com/fr/leggooglechartsbundle/doc/index (in french)
2. http://titouangalopin.com/en/leggooglechartsbundle/doc/index (in english)

About LegGoogleChartsBundle
-------------

LegGoogleChartsBundle is developped by Titouan Galopin.