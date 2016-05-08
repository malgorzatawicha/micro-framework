<?php require_once '../vendor/autoload.php';

require_once '../app/services.php';

/** @var \MW\Request $request */
$request = $di->getService('request');

/** @var \MW\Router $router */
$router = $di->getService('router');

$route = $router->execute($request);

$controller = $di->getNewService($route->getControllerClass());
