<?php

require_once 'vendor/autoload.php';

$dispatcher = new \MW\Commands\CommandDispatcher(array_slice($argv, 1));
$dispatcher->dispatch();
