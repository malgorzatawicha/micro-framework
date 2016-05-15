<?php namespace MW;

use MW\SQLBuilder\CustomQuery;
use MW\SQLBuilder\DeleteQuery;
use MW\SQLBuilder\InsertQuery;
use MW\SQLBuilder\SelectQuery;
use MW\SQLBuilder\UpdateQuery;

/**
 * Class SQLBuilderFactory
 * @package MW
 */
class SQLBuilderFactory
{
    
    const SELECT = 'SelectQuery';
    const INSERT = 'InsertQuery';
    const UPDATE = 'UpdateQuery';
    const DELETE = 'DeleteQuery';
    const CUSTOM = 'CustomQuery';

    /**
     * @var Connection
     */
    private $connection;

    /**
     * SQLBuilderFactory constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Connection
     */
    public function connection()
    {
        return $this->connection;
    }

    /**
     * @return SelectQuery
     */
    public function getSelectQuery()
    {
        return $this->newSqlBuilderInstance(self::SELECT);
    }

    /**
     * @return InsertQuery
     */
    public function getInsertQuery()
    {
        return $this->newSqlBuilderInstance(self::INSERT);
    }

    /**
     * @return DeleteQuery
     */
    public function getDeleteQuery()
    {
        return $this->newSqlBuilderInstance(self::DELETE);
    }

    /**
     * @return UpdateQuery
     */
    public function getUpdateQuery()
    {
        return $this->newSqlBuilderInstance(self::UPDATE);
    }

    /**
     * @return CustomQuery
     */
    public function getCustomQuery()
    {
        return $this->newSqlBuilderInstance(self::CUSTOM);
    }
    
    /**
     * @param string $type
     * @return SelectQuery|InsertQuery|UpdateQuery|DeleteQuery|CustomQuery
     */
    private function newSqlBuilderInstance($type)
    {
        $className = '\MW\SQLBuilder\\' . $type ;
        return new $className($this->connection);
    }
}
