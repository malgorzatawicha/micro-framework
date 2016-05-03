<?php namespace MW\SQLBuilder\Traits;

use MW\SQLBuilder\Criteria\Criteria;

trait HasWhereClause
{
    public function where(Criteria $criteria)
    {
        $this->clauses['where'][] = $criteria;
        return $this;
    }

    protected function whereClause()
    {
        if (empty($this->clauses['where'])) {
            return '';
        }
        
        $result = [];
        /** @var Criteria $criteria */
        foreach ($this->clauses['where'] as $criteria) {
            $result[] = $criteria->sql();
            $parameters = $criteria->parameters();
            if (!empty($parameters)) {
                $this->parameters = array_merge($this->parameters, $parameters);
            }
        }
        return "WHERE " . implode(' AND ', $result) . ' ';
    }
}
