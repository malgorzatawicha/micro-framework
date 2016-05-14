<?php namespace MW\Commands;

use MW\Connection;

abstract class Command
{
    protected $arguments;
    protected $connection;
    
    public function __construct(Connection $connection, array $arguments = [])
    {
        $this->connection = $connection;
        $this->arguments = $arguments;
    }

    abstract public function execute();
}
