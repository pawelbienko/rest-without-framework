<?php

use \Api\Library\Routing;

$collection = new Routing\RouteCollection();

$collection->add('locations/search', new Routing\Route(
    'locations/search/<query>',
    'GET',
    array(
        'class' => 'Api\Controller\LocationsController',
        'method' => 'searchByNameAction',
    ),
    array(
        'query' => '[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]+',
    )
));

$collection->add('locations/distance', new Routing\Route(
    'locations/distance/<distance>',
    'GET',
    array(
        'class' => 'Api\Controller\LocationsController',
        'method' => 'searchByDistanceAction',
    ),
    array(
        'distance' => "\d+",
    )
));

$collection->add('locations', new Routing\Route(
    'locations',
    'POST',
    array(
        'class' => 'Api\Controller\LocationsController',
        'method' => 'postAction',
    )
));

$collection->add('locations/put', new Routing\Route(
    'locations/<id>',
    'PUT',
    array(
        'class' => 'Api\Controller\LocationsController',
        'method' => 'putAction',
    ),
    array(
        'id' => "\d+",
    )
));

$collection->add('locations/delete', new Routing\Route(
    'locations/<id>',
    'DELETE',
    array(
        'class' => 'Api\Controller\LocationsController',
        'method' => 'deleteAction',
    ),
    array(
        'id' => "\d+",
    )
));

$collection->add('locations/get', new Routing\Route(
    'locations/<id>',
    'GET',
    array(
        'class' => 'Api\Controller\LocationsController',
        'method' => 'getOneAction',
    ),
    array(
        'id' => "\d+",
    )
));
