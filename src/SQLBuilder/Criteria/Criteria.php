<?php namespace MW\SQLBuilder\Criteria;

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
     * Criteria constructor.
     * @param string|null $column
     * @param mixed|null $value
     */
    public function __construct($column = null, $value = null)
    {
        $this->column = $column;
        $this->value = $value;
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