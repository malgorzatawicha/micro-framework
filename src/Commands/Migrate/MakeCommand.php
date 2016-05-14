<?php namespace MW\Commands\Migrate;

use MW\Commands\Command;

class MakeCommand extends Command
{
    private $sql = 'CREATE TABLE migration(  
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  migration VARCHAR(30),
  PRIMARY KEY (id)
)';
    public function execute()
    {
        $this->connection->executeGetLastInsertId($this->sql);
    }
}
