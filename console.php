<?php

require_once 'vendor/autoload.php';

$configs = require 'app/config/db.php';
$connectionFactory = new \MW\Connection\ConnectionFactory(
    new \MW\Connection\PDOFactory(),
    require 'app/config/db.php'
);

$dispatcher = new \MW\Commands\CommandDispatcher($connectionFactory->getConnection('default'), array_slice($argv, 1));
$dispatcher->dispatch();
