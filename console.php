<?php

require_once 'vendor/autoload.php';

$dispatcher = new \MW\Commands\CommandDispatcher(
    require 'app/commandServices.php',
    [
        \MW\Commands\Migrate\MakeCommand::class,
        \MW\Commands\MigrateCommand::class,
        \MW\Commands\Migrate\RollbackCommand::class,
        \MW\Commands\HelpCommand::class
    ],
    array_slice($argv, 1));
$dispatcher->dispatch();
