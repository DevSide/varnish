#Varnish module for Koahana 3

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
    Varnish::instance()->purge(array(
        URL::site('/page/to/purge'),
        URL::site('/page/to/purge')
    );
```