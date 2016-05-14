<?php namespace MW;
use MW\Connection\ConnectionException;

/**
 * Class Connection
 * @package MW
 */
class Connection
{
    private $driver;

    public function __construct(\PDO $driver)
    {
        $this->driver = $driver;
    }

    public function fetch($sql, $parameters = null) {
        $stmt = $this->execute($sql, $parameters);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        return $stmt->fetch();
    }
    
    public function fetchAll($sql, $parameters = null) {
        $stmt = $this->execute($sql, $parameters);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function executeGetLastInsertId($sql, $parameters = null) {
        $this->execute($sql, $parameters);
        return $this->driver->lastInsertId();
    }

    public function executeGetRowCount($sql, $parameters = null) {
        return $this->execute($sql, $parameters)->rowCount();
    }

    private function execute($sql, $parameters = null) {
        $stmt = $this->driver->prepare($sql);
        if ($stmt->execute($parameters)) {
            return $stmt;
        }
        throw new ConnectionException($stmt->errorInfo(), $stmt->errorCode());
    }
}
