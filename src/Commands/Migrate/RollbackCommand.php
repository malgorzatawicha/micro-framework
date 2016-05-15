<?php namespace MW\Commands\Migrate;

use MW\Commands\MigrateCommand;
use MW\SQLBuilder\Criteria\Equals;
use MW\SQLBuilder\CustomQuery;
use MW\SQLBuilder\DeleteQuery;
use MW\SQLBuilderFactory;

class RollbackCommand extends MigrateCommand
{
    public function __construct(SQLBuilderFactory $SQLBuilderFactory, array $migrations)
    {
        parent::__construct($SQLBuilderFactory, array_reverse($migrations, true));
    }

    protected function canExecuteCommand($migration, $migrationsInDb)
    {
        return in_array($migration, $migrationsInDb);
    }
    
    protected function executeCommand($data)
    {
        /** @var CustomQuery $custom */
        $custom = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::CUSTOM);
        $custom->query($data['down']);
        return $custom->execute();
    }

    protected function saveMigrationStatus($migration)
    {
        /** @var DeleteQuery $delete */
        $delete = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::DELETE);
        $delete->table('migrations')
            ->where(new Equals('migration', $migration))
            ->execute();
    }
}
