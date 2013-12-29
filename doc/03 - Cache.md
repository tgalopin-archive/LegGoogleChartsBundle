Cache
=====

The bundle provide a simple way to cache your charts, very easily, using the library `CacheEngine`.

### Enable the cache

To enable the cache, edit your `app/config/config.yml` file:

``` yml
leg_google_charts:
    cache_engine:
        enabled: true               # Enable the cache
        default_keep_time: 3600     # Set the default time to keep charts, in seconds
```

Using the `ChartsManager`, the cache will be enabled without any other action.
The `ChartsManager` will do all the job alone.

### Individual keep times

You can define a keep time for each chart individually, when you build it using `ChartsManager`:

``` php
$this->get('leg_google_charts')->build($chart, 5)
```

### Next Steps

The following documents are available:

- [03 - Cache](03 - Cache.md)