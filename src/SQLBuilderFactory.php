<?php namespace MW;

use MW\SQLBuilder\DeleteQuery;
use MW\SQLBuilder\InsertQuery;
use MW\SQLBuilder\Query;
use MW\SQLBuilder\SelectQuery;
use MW\SQLBuilder\UpdateQuery;

/**
 * Class SQLBuilderFactory
 * @package MW
 */
class SQLBuilderFactory
{
    const SELECT = 'select';
    const INSERT = 'insert';
    const UPDATE = 'update';
    const DELETE = 'delete';

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
     * @param string $type
     * @return Query
     * @throws UnrecognizedSqlQueryTypeException
     */
    public function newSqlBuilderInstance($type)
    {
        switch ($type) {
            case self::SELECT: 
                return new SelectQuery($this->connection);
            case self::INSERT:
                return new InsertQuery($this->connection);
            case self::UPDATE:
                return new UpdateQuery($this->connection);
            case self::DELETE:
                return new DeleteQuery($this->connection);
        }
        
        throw new UnrecognizedSqlQueryTypeException();
    }
}