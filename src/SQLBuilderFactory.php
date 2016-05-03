<?php namespace MW;

class SQLBuilderFactory
{
    const SELECT = 'select';
    const INSERT = 'insert';
    const UPDATE = 'update';
    const DELETE = 'delete';
    
    private $connection;
    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function newSqlBuilderInstance($type)
    {
        switch ($type) {
            case self::SELECT: 
                return null;
            case self::INSERT:
                return null;
            case self::UPDATE:
                return null;
            case self::DELETE:
                return null;
        }
        
        throw new UnrecognizedSqlQueryTypeException();
    }
}