<?php namespace MW\Commands;

use MW\Models\Migration;

/**
 * Class MigrateCommand
 * @package MW\Commands
 */
class MigrateCommand extends Command
{
    /**
     * @var Migration
     */
    protected $migrationModel;

    /**
     * @var array
     */
    protected $migrations = [];

    /**
     * MigrateCommand constructor.
     * @param Migration $migrationModel
     * @param array $migrations
     */
    public function __construct(Migration $migrationModel, array $migrations = [])
    {
        $this->migrationModel = $migrationModel;
        $this->migrations     = $migrations;
    }

    /**
     * @param array $arguments
     * @return bool
     */
    public function execute(array $arguments = [])
    {
        $migrationsInDb = $this->getMigrationsInDb();

        foreach ($this->migrations as $migration => $data) {
            if ($this->canExecuteCommand($migration, $migrationsInDb)) {
                $this->migrationModel->transaction(function() use($data, $migration) {
                    $this->executeCommand($data);
                    $this->saveMigrationStatus($migration);
                });
            }
        }
        return true;
    }

    /**
     * @return array
     */
    protected function getMigrationsInDb()
    {
        $result     = [];
        $migrations = $this->migrationModel->get();
        
        foreach ($migrations as $migration) {
            $result[] = (int)$migration['migration'];
        }
        return $result;
    }

    /**
     * @param int $migration
     * @param array $migrationsInDb
     * @return bool
     */
    protected function canExecuteCommand($migration, $migrationsInDb)
    {
        return !in_array($migration, $migrationsInDb);
    }

    /**
     * @param array $data
     * @return int
     */
    protected function executeCommand($data)
    {
        return $this->migrationModel->executeCustomQuery($data['up']);
    }

    /**
     * @param int $migration
     */
    protected function saveMigrationStatus($migration)
    {
        $this->migrationModel->insert(['migration' => $migration]);
    }
}
