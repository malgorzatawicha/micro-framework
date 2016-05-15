<?php namespace MW;

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

    public function insert(array $data)
    {
        /** @var InsertQuery $query */
        $query = $this->sqlBuilderFactory->newSqlBuilderInstance(SQLBuilderFactory::INSERT)
            ->table($this->tableName)
            ->data($data);
        return $query->insert();
    }
}
