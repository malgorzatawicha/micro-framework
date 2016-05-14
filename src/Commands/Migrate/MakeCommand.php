<?php namespace MW\Commands\Migrate;

use MW\Commands\Command;
use MW\SQLBuilder\CustomQuery;
use MW\SQLBuilderFactory;

class MakeCommand extends Command
{
    private $sql = 'CREATE TABLE migrations(migration int(11))';
    private $sqlBuilderFactory;
    
    public function __construct(SQLBuilderFactory $SQLBuilderFactory, array $arguments)
    {
        parent::__construct($arguments);
        $this->sqlBuilderFactory = $SQLBuilderFactory;
    }

    public function execute()
    {
        /** @var CustomQuery $queryBuilder */
        $queryBuilder = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::CUSTOM);
        $queryBuilder->query($this->sql);
        $queryBuilder->execute();
    }
}
