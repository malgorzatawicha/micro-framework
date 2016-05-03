<?php namespace MW;

use MW\SQLBuilder\Delete;
use MW\SQLBuilder\Insert;
use MW\SQLBuilder\Query;
use MW\SQLBuilder\Select;
use MW\SQLBuilder\Update;

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
                return new Select($this->connection);
            case self::INSERT:
                return new Insert($this->connection);
            case self::UPDATE:
                return new Update($this->connection);
            case self::DELETE:
                return new Delete($this->connection);
        }
        
        throw new UnrecognizedSqlQueryTypeException();
    }
}