#Varnish module for Kohana 3

This module allows you to send a special HTTP request to Varnish.
---

##Requirements
* PHP Curl extension
* You should have configured Varnish to purge an url

##Usage


```php
    // Single
    Varnish::instance()->purge(URL::site('/page/to/purge'));

    // Multi
    Varnish::instance()->purgeAll(array(
        URL::site('/page/to/purge'),
        URL::site('/page/to/purge')
    );
```