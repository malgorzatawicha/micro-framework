<?php namespace MW\Commands\Migrate;

use MW\Commands\Command;
use MW\Models\Migration;
use MW\SQLBuilder\CustomQuery;
use MW\SQLBuilderFactory;

class MakeCommand extends Command
{
    private $sql = 'CREATE TABLE migrations(migration int(11))';
    private $migrationModel;
    
    public function __construct(Migration $migrationModel)
    {
        $this->migrationModel = $migrationModel;
    }

    public function execute(array $arguments = [])
    {
        return $this->migrationModel->executeCustomQuery($this->sql);
    }
}
