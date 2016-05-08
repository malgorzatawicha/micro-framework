<?php require_once '../vendor/autoload.php';

require_once '../app/services.php';

$request = $di->getService('request');
$router = $di->getService('router');

$route = $router->execute($request);
