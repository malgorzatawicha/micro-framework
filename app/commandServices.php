<?php
$di = new \MW\DependencyInjectionContainer();

$di->addService('\MW\SQLQueryBuilder', function() use($di) {
    $connectionFactory = new \MW\Connection\ConnectionFactory(
        new \MW\Connection\PDOFactory(),
        require __DIR__ . '/config/db.php'
    );

    return new \MW\SQLBuilderFactory($connectionFactory->getConnection('default'));
});

$di->addService('\MW\Commands\HelpCommand', function() use($di) {
    $paths = [
        realpath(__DIR__ . '/../src/Commands'),
        realpath(__DIR__ . '/Commands/'),  
    ];
    return new \MW\Commands\HelpCommand(new \MW\DirectoryIteratorFactory(), new \MW\Output(), $paths);
});

$di->addService('\MW\Commands\Migrate\MakeCommand', function() use($di) {
    /** @var \MW\SQLBuilderFactory $sqlBuilderFactory */
    $sqlBuilderFactory = $di->getService('\MW\SQLBuilderFactory');
    return new \MW\Commands\Migrate\MakeCommand($sqlBuilderFactory);
});
$di->addService('\MW\Commands\MigrateCommand', function() use($di) {
    /** @var \MW\SQLBuilderFactory $sqlBuilderFactory */
    $sqlBuilderFactory = $di->getService('\MW\SQLBuilderFactory');
    return new \MW\Commands\MigrateCommand($sqlBuilderFactory, require __DIR__ . '/migrations.php');
});

$di->addService('\MW\Commands\Migrate\RollbackCommand', function() use($di) {
    /** @var \MW\SQLBuilderFactory $sqlBuilderFactory */
    $sqlBuilderFactory = $di->getService('\MW\SQLBuilderFactory');
    return new \MW\Commands\Migrate\RollbackCommand($sqlBuilderFactory, require __DIR__ . '/migrations.php');
});
return $di;
