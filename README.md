#Varnish module for Koahana 3

This module allows you to communicate with Mandrill API 1.0
[Mandrill API documentation](https://github.com/kohana/kohana)
---

##Requirements
* PHP Curl extension
* You should have configured Varnish to purge an url on

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