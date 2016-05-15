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
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function getSelectQuery()
    {
        return $this->newSqlBuilderInstance(self::SELECT);
    }

    /**
     * @param string $type
     * @return SelectQuery|InsertQuery|UpdateQuery|DeleteQuery|CustomQuery
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function newSqlBuilderInstance($type)
    {
        $className = '\MW\SQLBuilder\\' . $type ;
        if (class_exists($className)) {
            return new $className($this->connection);    
        }
        throw new UnrecognizedSqlQueryTypeException();
    }
}
