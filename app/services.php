<?php
$di = new \MW\DependencyInjectionContainer();

$di->addService('request', function() use($di) {
  return new \MW\Request(new \MW\RequestValue($GLOBALS));
});

$di->addService('response', function() use($di) {
    return new \MW\Response(new \MW\Output());
});


$di->addService('router', function() use($di) {
    $routes = require __DIR__ . '/routes.php';
    return new \MW\Router($routes);
});

$di->addService('\App\Controller\HomeController', function() use($di) {
    return new \App\Controllers\HomeController(
        $di->getService('request'),
        $di->getService('response')
    );
});

$di->addService('\App\Controller\GetFooController', function() use($di) {
   return new \App\Controllers\GetFooController(
       $di->getService('request'),
       $di->getService('response')
   ); 
});
