<?php namespace MW;

use MW\SQLBuilder\Criteria\Equals;
use MW\SQLBuilder\CustomQuery;
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
        /** @var SelectQuery $query */
        $query = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::SELECT)
            ->table($this->tableName)
            ->where(new SQLBuilder\Criteria\Equals($this->primaryKey, $id));
        return $query->first();
    }

    /**
     * @return array|null
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function get()
    {
        /** @var SelectQuery $query */
        $query = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::SELECT)
            ->table($this->tableName);
        return $query->all();
    }

    /**
     * @param array $data
     * @return string
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function insert(array $data)
    {
        /** @var InsertQuery $query */
        $query = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::INSERT)
            ->table($this->tableName)
            ->data($data);
        return $query->insert();
    }

    /**
     * @param array $data
     * @return int
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function delete(array $data)
    {
        $query = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::DELETE)
            ->table($this->tableName);
        foreach ($data as $key => $value) {
            $query->where(new Equals($key, $value));
        }
        return $query->execute();
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
     * @return int
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function executeCustomQuery($query)
    {
        /** @var CustomQuery $query */
        $query = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::CUSTOM);
        
        return $query->query($query)->execute();

    }
}
