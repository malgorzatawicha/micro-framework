<?php namespace MW\Commands;

use MW\Models\Migration;
use MW\SQLBuilder\CustomQuery;
use MW\SQLBuilder\InsertQuery;
use MW\SQLBuilder\SelectQuery;
use MW\SQLBuilderFactory;

class MigrateCommand extends Command
{
    protected $migrationModel;
    protected $migrations = [];
    
    public function __construct(Migration $migrationModel, array $migrations = [])
    {
        $this->migrationModel = $migrationModel;
        $this->migrations = $migrations;
    }
    
    public function execute(array $arguments = [])
    {
        $migrationsInDb = $this->getMigrationsInDb();

        foreach ($this->migrations as $migration => $data) {
            if ($this->canExecuteCommand($migration, $migrationsInDb)) {
                $self = $this;
                $this->migrationModel->transaction(function() use($self, $data, $migration) {
                    $this->executeCommand($data);
                    $this->saveMigrationStatus($migration);
                });
            }
        }
    }
    
    protected function getMigrationsInDb()
    {
        $result = [];
        $migrations = $this->migrationModel->get();
        
        foreach ($migrations as $migration) {
            $result[] = (int)$migration['migration'];
        }
        return $result;
    }

    protected function canExecuteCommand($migration, $migrationsInDb)
    {
        return !in_array($migration, $migrationsInDb);
    }

    protected function executeCommand($data)
    {
        return $this->migrationModel->executeCustomQuery($data['up']);
    }
    
    protected function saveMigrationStatus($migration)
    {
        $this->migrationModel->insert(['migration' => $migration]);
    }
}
