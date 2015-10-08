<?php

namespace Api\Library\Loader;

/**
 * Autoload.
 */
class AutoLoader
{
    private $namespace;
    public function __construct($namespace = null)
    {
        $this->namespace = $namespace;
        spl_autoload_register(array($this, 'autoload'));
    }
    /**
     * Handles autoloading of classes.
     *
     * @param string $className Name of the class to load
     * @return void
     */
    public function autoload($className)
    {
        if ($this->namespace == null || $this->namespace.'\\' === substr($className, 0, strlen($this->namespace.'\\'))) {
            $fileName = dirname(dirname(dirname(dirname(__FILE__)))).DIRECTORY_SEPARATOR;
            $namespace = '';
            if (false !== ($lastNsPos = strripos($className, '\\'))) {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
            }
            $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';
            require $fileName;
        }
    }
}
