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
    protected $connection;

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
        foreach ($this->clauses as $name => $clause) {
            $methodName   = $name . 'Clause';
            $clauseResult = $this->$methodName($clause);
            if (!is_array($clauseResult)) {
                $result .= $clauseResult;
            } else {
                $result          .= array_shift($clauseResult);
                $this->parameters = array_merge($this->parameters, array_shift($clauseResult));
            }
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

    /**
     * @return int
     */
    public function execute()
    {
        return $this->connection->execute($this->sql(), $this->parameters());
    }

    protected function escapeNames(array $names)
    {
        $result = [];
        foreach ($names as $name) {
            $result[] = $this->connection->escapeName($name);
        }
        return $result;
    }
}
