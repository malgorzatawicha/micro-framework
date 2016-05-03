<?php namespace MW\SQLBuilder\Criteria;

class Equals extends Criteria
{
    public function sql()
    {
        if (empty($this->column) || empty($this->value)) {
            return '';
        }
        return "{$this->column}=?";
    }
    
    public function parameters()
    {
        return [$this->value];
    }
}