<?php namespace MW\Commands\Migrate;

use MW\Commands\Command;

class MakeCommand extends Command
{
    private $sql = 'CREATE TABLE migrations(  
  migration int(11)
)';
    public function execute()
    {
        $this->connection->executeGetLastInsertId($this->sql);
    }
}
