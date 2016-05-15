<?php namespace MW\Commands\Migrate;

use MW\Commands\MigrateCommand;
use MW\Models\Migration;
use MW\SQLBuilder\Criteria\Equals;
use MW\SQLBuilder\CustomQuery;
use MW\SQLBuilder\DeleteQuery;
use MW\SQLBuilderFactory;

class RollbackCommand extends MigrateCommand
{
    public function __construct(Migration $migrationModel, array $migrations)
    {
        parent::__construct($migrationModel, array_reverse($migrations, true));
    }

    protected function canExecuteCommand($migration, $migrationsInDb)
    {
        return in_array($migration, $migrationsInDb);
    }
    
    protected function executeCommand($data)
    {
        return $this->migrationModel->executeCustomQuery($data['down']);
    }

    protected function saveMigrationStatus($migration)
    {
        return $this->migrationModel->delete(['migration' => $migration]);
    }
}
