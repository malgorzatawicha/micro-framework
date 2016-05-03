<?php namespace MW\SQLBuilder;

use MW\Connection;

abstract class Query
{
    private $connection;
    protected $clauses = [];
    protected $parameters = [];
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    
    abstract public function sql();
    
    public function parameters()
    {
        return $this->parameters;
    }
}