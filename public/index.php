<?php require_once '../vendor/autoload.php';

require_once '../app/services.php';

/** @var \MW\Request $request */
$request = $di->getService('request');

/** @var \MW\Router $router */
$router = $di->getService('router');

$controller = $di->getNewService($router->execute($request));

/** @var \MW\Response $response */
$response = $controller->execute();
$response->send();
