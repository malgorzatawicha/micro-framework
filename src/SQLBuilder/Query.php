<?php namespace MW\SQLBuilder;

use MW\Connection;

/**
 * Class Query
 * @package MW\SQLBuilder
 */
abstract class Query
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var array
     */
    protected $clauses = [];

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Query constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return mixed
     */
    abstract public function sql();

    /**
     * @return array
     */
    public function parameters()
    {
        return $this->parameters;
    }
}