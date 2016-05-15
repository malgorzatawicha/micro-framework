<?php namespace MW\SQLBuilder\Criteria;
use MW\Connection;

/**
 * Class Criteria
 * @package MW\SQLBuilder\Criteria
 */
abstract class Criteria
{
    /**
     * @var null|string
     */
    protected $column;

    /**
     * @var mixed|null
     */
    protected $value;

    /**
     * @var Connection
     */
    protected $connection;
    /**
     * Criteria constructor.
     * @param Connection $connection
     * @param string|null $column
     * @param mixed|null $value
     */
    public function __construct(Connection $connection, $column = null, $value = null)
    {
        $this->connection = $connection;
        $this->column     = $column;
        $this->value      = $value;
    }

    /**
     * @return string
     */
    abstract public function sql();

    /**
     * @return array
     */
    abstract public function parameters();
}
