<?php

namespace Api\Library\Routing;

/**
 * This class contains a collection element of class Route.
 */
class RouteCollection
{
    /**
     * @var array An array of objects Route class
     */
    protected $items;

    /**
     * Function adds a Route to the collection.
     *
     * @param string $name Name of elements
     * @param Route  $item Object Route
     */
    public function add($name, $item)
    {
        $this->items[$name] = $item;
    }

    /**
     * Return Route object.
     *
     * @param string $name Name object in collection
     *
     * @return Route|null
     */
    public function get($name)
    {
        if (array_key_exists($name, $this->items)) {
            return $this->items[$name];
        } else {
            return;
        }
    }

    /**
     * Returns all objects of collection.
     *
     * @return array array
     */
    public function getAll()
    {
        return $this->items;
    }
}
