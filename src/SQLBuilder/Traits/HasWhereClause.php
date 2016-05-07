<?php namespace MW\SQLBuilder\Traits;

use MW\SQLBuilder\Criteria\Criteria;

/**
 * Class HasWhereClause
 * @package MW\SQLBuilder\Traits
 */
trait HasWhereClause
{
    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function where(Criteria $criteria)
    {
        $this->clauses['where'][] = $criteria;
        return $this;
    }

    /**
     * @return string
     */
    protected function whereClause()
    {
        if (empty($this->clauses['where'])) {
            return '';
        }
        
        $result = [];
        /** @var Criteria $criteria */
        foreach ($this->clauses['where'] as $criteria) {
            $result[]   = $criteria->sql();
            $parameters = $criteria->parameters();
            if (!empty($parameters)) {
                $this->parameters = array_merge($this->parameters, $parameters);
            }
        }
        return 'WHERE ' . implode(' AND ', $result) . ' ';
    }
}
