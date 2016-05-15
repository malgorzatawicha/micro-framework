<?php
$di = new \MW\DependencyInjectionContainer();

$di->addService('request', function() {
  return new \MW\Request(new \MW\RequestValue($GLOBALS));
});

$di->addService('response', function() use ($di) {
    return new \MW\Response($di->getService('output'));
});
$di->addService('output', function() {
    return new \MW\Output();   
});

$di->addService('router', function() {
    $routes = require __DIR__ . '/routes.php';
    return new \MW\Router($routes);
});

$di->addService('view', function() use($di) {
    return new \MW\View($di->getService('response'), __DIR__ . '/views/');
});

$di->addService('MW\SQLQueryBuilderFactory', function() use($di) {
    $connectionFactory = new \MW\Connection\ConnectionFactory(
        new \MW\Connection\PDOFactory(),
        require __DIR__ . '/config/db.php'
    );

    return new \MW\SQLBuilderFactory($connectionFactory->getConnection('default'));
});

$di->addService('\App\Models\Post', function() use ($di){
    return new \App\Models\Post($di->getService('MW\SQLQueryBuilderFactory'));
});

$di->addService('\App\Controllers\HomeController', function() use($di) {
    /** @var \MW\Request $request */
    $request = $di->getService('request');
    /** @var \MW\Response $response */
    $response = $di->getService('response');
    return new \App\Controllers\HomeController($request, $response);
});

$di->addService('\App\Controllers\PostsController', function() use($di) {
    /** @var \MW\Request $request */
    $request = $di->getService('request');
    /** @var \MW\Response $response */
    $response = $di->getService('response');

    /** @var \App\Models\Post $model */
    $model = $di->getService('\App\Models\Post');

    /** @var \MW\View $view */
    $view = $di->getService('view');

    return new \App\Controllers\PostsController($request, $response, $view, $model);
});
