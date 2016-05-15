<?php namespace MW;

use MW\SQLBuilder\Criteria\Equals;
use MW\SQLBuilder\CustomQuery;
use MW\SQLBuilder\InsertQuery;
use MW\SQLBuilder\SelectQuery;

class Model
{
    protected $sqlBuilderFactory;

    protected $tableName;
    protected $primaryKey;

    public function __construct(SQLBuilderFactory $builderFactory)
    {
        $this->sqlBuilderFactory = $builderFactory;
    }

    public function find($id)
    {
        /** @var SelectQuery $query */
        $query = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::SELECT)
            ->table($this->tableName)
            ->where(new SQLBuilder\Criteria\Equals($this->primaryKey, $id));
        return $query->first();
    }

    public function get()
    {
        /** @var SelectQuery $query */
        $query = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::SELECT)
            ->table($this->tableName);
        return $query->all();
    }

    public function insert(array $data)
    {
        /** @var InsertQuery $query */
        $query = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::INSERT)
            ->table($this->tableName)
            ->data($data);
        return $query->insert();
    }

    public function delete(array $data)
    {
        $query = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::DELETE)
            ->table($this->tableName);
        foreach ($data as $key => $value) {
            $query->where(new Equals($key, $value));
        }
        return $query->execute();
    }
    
    public function transaction(callable $callable)
    {
        $this->sqlBuilderFactory->connection()->transaction($callable);
    }

    public function executeCustomQuery($query)
    {
        return $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::CUSTOM)
            ->query($query)->execute();

    }
}
