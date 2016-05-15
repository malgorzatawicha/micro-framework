<?php namespace MW\Commands;

use MW\SQLBuilder\CustomQuery;
use MW\SQLBuilder\InsertQuery;
use MW\SQLBuilder\SelectQuery;
use MW\SQLBuilderFactory;

class MigrateCommand extends Command
{
    protected $sqlBuilderFactory;
    protected $migrations = [];
    
    public function __construct(SQLBuilderFactory $SQLBuilderFactory, array $migrations = [])
    {
        $this->sqlBuilderFactory = $SQLBuilderFactory;
        $this->migrations = $migrations;
    }
    
    public function execute(array $arguments = [])
    {
        $migrationsInDb = $this->getMigrationsInDb();

        foreach ($this->migrations as $migration => $data) {
            if ($this->canExecuteCommand($migration, $migrationsInDb)) {
                $self = $this;
                $this->sqlBuilderFactory->connection()->transaction(function() use($self, $data, $migration) {
                    $this->executeCommand($data);
                    $this->saveMigrationStatus($migration);
                });
            }
        }
    }
    
    protected function getMigrationsInDb()
    {
        $result = [];
        /** @var SelectQuery $select */
        $select = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::SELECT);
        $select->table('migrations');
        
        $migrations = $select->all();
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
        /** @var CustomQuery $custom */
        $custom = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::CUSTOM);
        $custom->query($data['up']);
        return $custom->execute();
    }
    
    protected function saveMigrationStatus($migration)
    {
        /** @var InsertQuery $insert */
        $insert = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::INSERT);
        $insert->table('migrations')
            ->data(['migration' => $migration])
            ->execute();
    }
}
