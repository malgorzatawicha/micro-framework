<?php namespace MW;

use MW\SQLBuilder\Criteria\Equals;
use MW\SQLBuilder\CustomQuery;
use MW\SQLBuilder\DeleteQuery;
use MW\SQLBuilder\InsertQuery;
use MW\SQLBuilder\SelectQuery;

/**
 * Class Model
 * @package MW
 */
abstract class Model
{
    /**
     * @var SQLBuilderFactory
     */
    protected $sqlBuilderFactory;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var string
     */
    protected $primaryKey;

    /**
     * Model constructor.
     * @param SQLBuilderFactory $builderFactory
     */
    public function __construct(SQLBuilderFactory $builderFactory)
    {
        $this->sqlBuilderFactory = $builderFactory;
    }

    /**
     * @param int $id
     * @return array|null
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function find($id)
    {
        return $this->sqlBuilderFactory->getSelectQuery()->table($this->tableName)
            ->where(new Equals($this->primaryKey, $id))->first();
    }

    /**
     * @return array|null
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function get()
    {
        return $this->sqlBuilderFactory->getSelectQuery()->table($this->tableName)->all();
    }
    
    /**
     * @param array $data
     * @return string
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function insert(array $data)
    {
        return $this->sqlBuilderFactory->getInsertQuery()->table($this->tableName)->data($data)->insert();
    }
    
    /**
     * @param array $data
     * @return int
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function delete(array $data)
    {
        $deleteQuery = $this->sqlBuilderFactory->getDeleteQuery()->table($this->tableName);
        foreach ($data as $key => $value) {
            $deleteQuery->where(new Equals($key, $value));
        }
        return $deleteQuery->execute();
    }
    
    /**
     * @param callable $callable
     * @throws \Exception
     */
    public function transaction(callable $callable)
    {
        $this->sqlBuilderFactory->connection()->transaction($callable);
    }

    /**
     * @param string $query
     * @param array|null $parameters
     * @return int
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function executeCustomQuery($query, $parameters = null)
    {
        return $this->sqlBuilderFactory->getCustomQuery()->query($query, $parameters)->execute();
    }
}
