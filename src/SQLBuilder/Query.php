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
     * @return bool
     */
    abstract protected function canBuildSql();
    
    /**
     * @return string
     */
    public function sql()
    {
        if (!$this->canBuildSql()) {
            return '';
        }
        
        $result = '';
        foreach (array_keys($this->clauses) as $name) {
            $methodName = $name . 'Clause';
            $result    .= $this->$methodName();
        }
        return trim($result);
    }

    /**
     * @return array
     */
    public function parameters()
    {
        return $this->parameters;
    }
    
    public function first()
    {
        return $this->connection->fetch($this->sql(), $this->parameters());
    }
    
    public function all()
    {
        return $this->connection->fetchAll($this->sql(), $this->parameters());
    }
    
    public function execute()
    {
        return $this->connection->execute($this->sql(), $this->parameters());
    }
}
