<?php

require_once 'vendor/autoload.php';

$dispatcher = new \MW\Commands\CommandDispatcher(require 'app/commandServices.php', array_slice($argv, 1));
$dispatcher->dispatch();
