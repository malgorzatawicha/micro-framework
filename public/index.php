<?php require_once '../vendor/autoload.php';

require_once '../app/services.php';

/** @var \MW\Request $request */
$request = $di->getService('request');

/** @var \MW\Router $router */
$router = $di->getService('router');

list($controllerName, $action) = $router->execute($request);
$controller = $di->getNewService($controllerName);

if (empty($controller)) {
    $controller = new $controllerName($di->getService('request'), $di->getService('response'));
}
/** @var \MW\Response $response */
$response = $controller->$action();

if (is_string($response)) {
    $di->getService('output')->content($response);
} else if ($response instanceof \MW\View) {
    $di->getService('response')->setContent((string)$response)->send();
} else if ($response instanceof \MW\Response) {
    $response->send();
}
