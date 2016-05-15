<?php namespace MW;
use MW\Connection\ConnectionException;

/**
 * Class Connection
 * @package MW
 */
class Connection
{
    /**
     * @var \PDO
     */
    protected $driver;

    /**
     * Connection constructor.
     * @param \PDO $driver
     */
    public function __construct(\PDO $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param callable $function
     * @throws \Exception
     */
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

    /**
     * @param string $sql
     * @param array|null $parameters
     * @return array|null
     */
    public function fetch($sql, $parameters = null) {
        $stmt = $this->statementForFetch($sql, $parameters);
        return $stmt->fetch();
    }

    /**
     * @param string $sql
     * @param array|null $parameters
     * @return array|null
     */
    public function fetchAll($sql, $parameters = null) {
        $stmt = $this->statementForFetch($sql, $parameters);
        return $stmt->fetchAll();
    }

    /**
     * @param string $sql
     * @param array|null $parameters
     * @return string
     * @throws ConnectionException
     */
    public function insert($sql, $parameters = null) {
        $this->statement($sql, $parameters);
        return $this->driver->lastInsertId();
    }

    /**
     * @param string $sql
     * @param array|null $parameters
     * @return int
     * @throws ConnectionException
     */
    public function execute($sql, $parameters = null) {
        return $this->statement($sql, $parameters)->rowCount();
    }

    /**
     * @param string $sql
     * @param array|null $parameters
     * @return \PDOStatement
     * @throws ConnectionException
     */
    private function statementForFetch($sql, $parameters = null)
    {
        $stmt = $this->statement($sql, $parameters);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        return $stmt;
    }

    /**
     * @param string $sql
     * @param array|null $parameters
     * @return \PDOStatement
     * @throws ConnectionException
     */
    private function statement($sql, $parameters = null) {
        $stmt = $this->driver->prepare($sql);
        if ($stmt->execute($parameters)) {
            return $stmt;
        }

        throw new ConnectionException($stmt->errorInfo()[2]);
    }
}
