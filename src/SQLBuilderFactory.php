<?php namespace MW;

class SQLBuilderFactory
{
    private $connection;
    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}