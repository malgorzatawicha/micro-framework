<?php namespace MW;

class SQLBuilder
{
    private $connection;
    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}