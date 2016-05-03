<?php namespace MW\SQLBuilder\Criteria;

abstract class Criteria
{
    protected $column;
    protected $value;
    
    public function __construct($column = null, $value = null)
    {
        $this->column = $column;
        $this->value = $value;
    }

    abstract public function sql();
    abstract public function parameters();
}