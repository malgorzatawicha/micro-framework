<?php namespace MW\SQLBuilder;

/**
 * Class CustomQuery
 * @package MW\SQLBuilder
 */
class CustomQuery extends Query
{
    /**
     * @var array
     */
    protected $clauses = [
        'custom' => ''
    ];

    /**
     * @param $query
     * @param array|null $parameters
     * @return $this
     */
    public function query($query, $parameters = null)
    {
        $this->clauses['custom'] = [
            'query' => $query,
            'parameters' => $parameters
        ];
        return $this;
    }

    /**
     * @return bool
     */
    protected function canBuildSql()
    {
        return !empty($this->clauses['custom']);
    }

    /**
     * @param array $clause
     * @return mixed
     */
    protected function customClause(array $clause)
    {
        $parameters = [];
        if (!empty($clause['parameters'])) {
            $parameters = $clause['parameters'];
            if (!is_array($parameters)) {
                $parameters = [$parameters];
            }
        }
        return [$clause['query'], $parameters];
    }
}
