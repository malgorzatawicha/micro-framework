<?php namespace MW;
use MW\Connection\ConnectionException;

/**
 * Class Connection
 * @package MW
 */
class Connection
{
    protected $driver;

    public function __construct(\PDO $driver)
    {
        $this->driver = $driver;
    }

    public function transaction(callable $function)
    {
        $this->driver->beginTransaction();
        try {
            $function();
            $this->driver->commit();

        } catch (\Exception $e) {
            $this->driver->rollBack();
            throw $e;
        }
    }

    public function fetch($sql, $parameters = null) {
        $stmt = $this->statementForFetch($sql, $parameters);
        return $stmt->fetch();
    }
    
    public function fetchAll($sql, $parameters = null) {
        $stmt = $this->statementForFetch($sql, $parameters);
        return $stmt->fetchAll();
    }

    public function insert($sql, $parameters = null) {
        $this->statement($sql, $parameters);
        return $this->driver->lastInsertId();
    }

    public function execute($sql, $parameters = null) {
        return $this->statement($sql, $parameters)->rowCount();
    }
    
    private function statementForFetch($sql, $parameters = null)
    {
        $stmt = $this->statement($sql, $parameters);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        return $stmt;
    }
    
    private function statement($sql, $parameters = null) {
        $stmt = $this->driver->prepare($sql);
        if ($stmt->execute($parameters)) {
            return $stmt;
        }

        throw new ConnectionException($stmt->errorInfo()[2]);
    }
}
