<?php namespace MW\SQLBuilder\Criteria;

/**
 * Class Equals
 * @package MW\SQLBuilder\Criteria
 */
class Equals extends Criteria
{
    /**
     * @return string
     */
    public function sql()
    {
        if (empty($this->column) || empty($this->value)) {
            return '';
        }
        return $this->column . '=?';
    }

    /**
     * @return array
     */
    public function parameters()
    {
        return [$this->value];
    }
}