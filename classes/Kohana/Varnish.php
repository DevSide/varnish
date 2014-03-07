<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * @author DevSide
 * @year 2014
 */

class Kohana_Varnish
{

    // Varnish instances
    protected static $_instance;

    /**
     * Singleton pattern
     *
     * @return Varnish
     */
    public static function instance()
    {
        if (!isset(Varnish::$_instance)) {
            // Load the configuration for this type
            $config = Kohana::$config->load('varnish');

            // Create a new session instance
            Varnish::$_instance = new Varnish($config);
        }

        return Varnish::$_instance;
    }


    private $_config;

    /**
     * Loads Varnish and configuration options.
     *
     * @param array $config
     * @return \Kohana_Varnish
     */
    public function __construct($config = array())
    {
        $this->_config = $config;
    }


    /**
     * Purge an url throw Varnish
     * Unix command line equivalent: curl -x METHOD YOUR_URL
     *
     * @param $url
     * @throws Kohana_Exception
     * @return mixed
     */
    private function _purge($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->_config['METHOD']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        if(curl_error($ch)) {
            throw new Kohana_Exception("Curl failed for $url: " . curl_error($ch));
        }

        if(( $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE) ) != $this->_config['SUCCESS_HTTP_CODE']){
            curl_close($ch);
            throw new Kohana_Exception("Purge failed for $url with HTTP code $httpCode");
        }

        curl_close($ch);

        return $result;
    }

    /**
     * Purge an url
     *
     * @param $url url to purge
     * @return mixed
     */
    public function purge($url)
    {
        return $this->_purge($url);
    }

    /**
     * Purge a list of urls
     *
     * @param array $urls List of urls to purge
     * @return mixed | NULL
     */
    public function purgeAll(array $urls)
    {
        if(count($urls) <= 0){
            return NULL;
        }

        $result = "";
        foreach($urls as $url){
            $result .= $this->_purge($url);
        }

        return $result;
    }
}
