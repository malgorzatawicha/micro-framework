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
        $totalParameters = [];
        
        $result = [];
        /** @var Criteria $criteria */
        foreach ($this->clauses['where'] as $criteria) {
            $result[]   = $criteria->sql();
            $parameters = $criteria->parameters();
            if (!empty($parameters)) {
                $totalParameters = array_merge($totalParameters, $parameters);
            }
        }
        return ['WHERE ' . implode(' AND ', $result) . ' ', $totalParameters];
    }
}
