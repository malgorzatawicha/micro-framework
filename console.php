<?php

require_once 'vendor/autoload.php';

$configs = require 'app/config/db.php';
$connectionFactory = new \MW\Connection\ConnectionFactory(
    new \MW\Connection\PDOFactory(),
    require 'app/config/db.php'
);

$sqlBuilderFactory = new \MW\SQLBuilderFactory($connectionFactory->getConnection('default'));
$dispatcher = new \MW\Commands\CommandDispatcher($sqlBuilderFactory, array_slice($argv, 1));
$dispatcher->dispatch();
