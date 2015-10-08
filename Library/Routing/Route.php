<?php

namespace Api\Library\Routing;

/**
 * This class contains a single element to routing.
 */
class Route
{
    /**
     * @var string Path URL.
     */
    protected $path;
    /**
     * @var string Class name.
     */
    protected $class;
    /**
     * @var string Method name.
     */
    protected $method;
    /**
     * @var string Request method name.
     */
    protected $requestMethod;
    /**
     * @var array It contains the default values for the parameters.
     */
    protected $defaults;
    /**
     * @var array It includes processing rules for parameters.
     */
    protected $params;

    /**
     * @param string $path          URL Path.
     * @param string $requestMethod Name supported the request method.
     * @param array  $config        Array with the path to the controller 
     * and method name.
     * @param array  $params        Array with parameters processing rule.
     * @param array  $defaults      Array with default values for the parameters.
     * @return void
     */
    public function __construct(
        $path,
        $requestMethod,
        $config,
        $params = array(),
        $defaults = array()
    ) {
        $this->path = $path;
        $this->method = $config['method'];
        $this->requestMethod = $requestMethod;
        $this->class = $config['class'];
        $this->setParams($params);
        $this->setDefaults($defaults);
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
     * @param array $defaults
     */
    public function setDefaults($defaults)
    {
        $this->defaults = $defaults;
    }

    /**
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @param string $requestMethod
     */
    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
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
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = HTTP_SERVER.$path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
