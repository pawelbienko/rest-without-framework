<?php

namespace Api\Library\Routing;

/**
 * Router Class.
 */
class Router
{
    /**
     * @var String URL to processing
     */
    protected $url;
    /**
     * @var string URL to main dir
     */
    protected $basePath;
    /**
     * @var array Contains Object RouteCollecion.
     */
    protected static $collection;
    /**
     * @var string Class name
     */
    protected $class;
    /**
     * @var string Method name
     */
    protected $method;

    public function __construct($url, $collection = null)
    {
        if ($collection != null) {
            self::$collection = $collection;
        }
        $this->url = $url;
    }

    /**
     * @param array $collection
     */
    public function setCollection($collection)
    {
        self::$collection = $collection;
    }

    /**
     * @return array
     */
    public function getCollection()
    {
        return self::$collection;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param String $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return String
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Checks if the URL matches the transmitted rule.
     *
     * @param Route $route Object
     *
     * @return bool
     */
    protected function matchRoute($route)
    {
        $params = array();
        $key_params = array_keys($route->getParams());

        $value_params = $route->getParams();

        foreach ($key_params as $key) {
            $params['<'.$key.'>'] = $value_params[$key];
        }
        $url = $this->basePath.$route->getPath();

        // Replaces the corresponding marks on regular expressions
        $url = str_replace(array_keys($params), $params, $url);

        // If no tag in the $ params array allows for any character
        $url = preg_replace('/<\w+>/', '.*', $url);
        // checks pattern matching
        preg_match("#^$url$#", $this->url, $results);
        if ($results) {
            $this->class = $route->getClass();
            $this->method = $route->getMethod();

            return true;
        }

        return false;
    }

    /**
     * Looking for an appropriate rule matching URL. If it finds returns true.
     *
     * @return bool
     */
    public function run()
    {
        $requestMethod = (
            isset($_POST['_method'])
            && ($_method = strtoupper($_POST['_method']))
            && in_array($_method, array('PUT', 'DELETE'))
        ) ? $_method : $_SERVER['REQUEST_METHOD'];

        foreach (self::$collection->getAll() as $route) {
            if (!in_array($requestMethod, (array) $route->getRequestMethod())) {
                continue;
            }
            if ($this->matchRoute($route)) {
                $this->setGetData($route);

                return true;
            }
        }

        return false;
    }

    /**
     * @param Route $route Route object matching rules
     */
    protected function setGetData($route)
    {
        $routePath = str_replace(array('(', ')'), array('', ''), $route->getPath());
        $trim = explode('<', $routePath);
        $parsed_url = str_replace(array($this->basePath), array(''), $this->url);
        $parsed_url = preg_replace("#$trim[0]#", '', $parsed_url, 1);
        // sets the parameters passed in the URL
        foreach ($route->getParams() as $key => $param) {
            preg_match("#$param#", $parsed_url, $results);
            if (isset($results[0])) {
                $_GET[$key] = $results[0];
                $parsed_url = str_replace($results[0], '', $parsed_url);
            }
        }
        // if no parameter in the URL, it sets the default values from the table
        foreach ($route->getDefaults() as $key => $default) {
            if (!isset($_GET[$key])) {
                $_GET[$key] = $default;
            }
        }
    }
}
