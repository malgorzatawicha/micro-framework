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
        return $this->doFind(
            $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::SELECT),
            $id);
    }

    /**
     * @param SelectQuery $selectQuery
     * @param int $id
     * @return array|null
     */
    private function doFind(SelectQuery $selectQuery, $id)
    {
        return $selectQuery->table($this->tableName)
            ->where(new Equals($this->primaryKey, $id))->first();
    }

    /**
     * @return array|null
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function get()
    {
        return $this->doGet($this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::SELECT));
    }

    /**
     * @param SelectQuery $selectQuery
     * @return array|null
     */
    private function doGet(SelectQuery $selectQuery)
    {
        return $selectQuery->table($this->tableName)->all();
    }
    
    /**
     * @param array $data
     * @return string
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function insert(array $data)
    {
        return $this->doInsert(
            $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::INSERT),
            $data);
    }

    /**
     * @param InsertQuery $insertQuery
     * @param array $data
     * @return string
     */
    private function doInsert(InsertQuery $insertQuery, array $data)
    {
        return $insertQuery->table($this->tableName)->data($data)->insert();
    }
    
    /**
     * @param array $data
     * @return int
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function delete(array $data)
    {
        return $this->doDelete(
            $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::DELETE),
            $data);
    }

    /**
     * @param DeleteQuery $deleteQuery
     * @param array $data
     * @return int
     */
    private function doDelete(DeleteQuery $deleteQuery, array $data)
    {
        $deleteQuery->table($this->tableName);
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
        return $this->doExecuteCustomQuery(
            $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::CUSTOM),
            $query, 
            $parameters
        );
    }

    /**
     * @param CustomQuery $customQuery
     * @param string $sql
     * @param array|null $parameters
     * @return int
     */
    private function doExecuteCustomQuery(CustomQuery $customQuery, $sql, $parameters = null)
    {
        return $customQuery->query($sql, $parameters)->execute();
    }
}
