Installation
===================

#### Step 1) Get the bundle

Download the bundle on GitHub :
	https://github.com/leglopin/GoogleChartsBundle-for-Symfony-2

And put the "Leg" directory in "vendor/bundles".

### Step 2) Register the namespaces

Add the following namespace entry to the `registerNamespaces` call
in your autoloader:

``` php
<?php
// app/autoload.php
$loader->registerNamespaces(array(
    // ...
    'Leg' => __DIR__.'/../vendor/bundles',
    // ...
));
```

### Step 3) Register the bundle

To start using the bundle, register it in your Kernel:

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