<?php namespace MW\Commands\Migrate;

use MW\Commands\MigrateCommand;
use MW\Models\Migration;

/**
 * Class RollbackCommand
 * @package MW\Commands\Migrate
 */
class RollbackCommand extends MigrateCommand
{
    /**
     * RollbackCommand constructor.
     * @param Migration $migrationModel
     * @param array $migrations
     */
    public function __construct(Migration $migrationModel, array $migrations)
    {
        parent::__construct($migrationModel, array_reverse($migrations, true));
    }

    /**
     * @param int $migration
     * @param array $migrationsInDb
     * @return bool
     */
    protected function canExecuteCommand($migration, $migrationsInDb)
    {
        return in_array($migration, $migrationsInDb);
    }

    /**
     * @param array $data
     * @return int
     */
    protected function executeCommand($data)
    {
        return $this->migrationModel->executeCustomQuery($data['down']);
    }

    /**
     * @param int $migration
     * @return int
     */
    protected function saveMigrationStatus($migration)
    {
        return $this->migrationModel->delete(['migration' => $migration]);
    }
}
