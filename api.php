<?php

require_once 'config.php';
require_once 'Library/Loader/AutoLoader.php';
$loader = new Api\Library\Loader\Autoloader();

require_once 'config-router.php';

use Api\Controller;

if (!Controller\AuthenticationController::isLogged()) {
    Controller\AuthenticationController::unauthorized();
}

if (!Api\Controller\AuthenticationController::login()) {
    Controller\AuthenticationController::unauthorized();
}

$router = new Api\Library\Routing\Router('http://'.$_SERVER['SERVER_NAME']
        .$_SERVER['REQUEST_URI'], $collection);
$router->setBasePath(BASEPATH);

if ($router->run()) {
    try {
        $classController = $router->getClass();
        $method = $router->getMethod();
        $obj = new $classController();
        $response = $obj->$method();
    } catch (Exception $e) {
        header('HTTP/1.0 400 Bad Request');
        $response = 'Something goes wrong :)';
    }
} else {
    header('HTTP/1.0 400 Bad Request');
    $response = 'Unknown Request';
}
echo json_encode($response);
