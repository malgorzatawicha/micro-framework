<?php
$di = new \MW\DependencyInjectionContainer();

$di->addService('request', function() {
  return new \MW\Request(new \MW\RequestValue($GLOBALS));
});

$di->addService('response', function() {
    return new \MW\Response(new \MW\Output());
});


$di->addService('router', function() {
    $routes = require __DIR__ . '/routes.php';
    return new \MW\Router($routes);
});

$di->addService('\App\Controllers\HomeController', function() use($di) {
    /** @var \MW\Request $request */
    $request = $di->getService('request');
    /** @var \MW\Response $response */
    $response = $di->getService('response');
    return new \App\Controllers\HomeController($request, $response);
});

