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
     * @param array $clause
     * @return string|array<string|array>
     */
    protected function whereClause(array $clause)
    {
        if (empty($clause)) {
            return '';
        }
        $totalParameters = [];
        
        $result = [];
        /** @var Criteria $criteria */
        foreach ($clause as $criteria) {
            $result[]   = $criteria->sql();
            $parameters = $criteria->parameters();
            if (!empty($parameters)) {
                $totalParameters = array_merge($totalParameters, $parameters);
            }
        }
        return ['WHERE ' . implode(' AND ', $result) . ' ', $totalParameters];
    }
}
