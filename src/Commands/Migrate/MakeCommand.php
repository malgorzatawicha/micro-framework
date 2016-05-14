<?php namespace MW\Commands\Migrate;

use MW\Commands\Command;
use MW\SQLBuilderFactory;

class MakeCommand extends Command
{
    private $sql = 'CREATE TABLE migrations(  
  migration int(11)
)';
    public function execute()
    {
        $queryBuilder = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::CUSTOM);
        $queryBuilder->query($this->sql);
        $queryBuilder->execute();
    }
}
