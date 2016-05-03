<?php namespace MW\SQLBuilder;

use MW\Connection;

abstract class Query
{
    private $connection;
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    
    abstract public function sql();
}