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
     * @param null $parameters
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
     * @return mixed
     */
    protected function customClause()
    {
        $parameters = [];
        if (!empty($this->clauses['custom']['parameters'])) {
            $parameters = $this->clauses['custom']['parameters'];
            if (!is_array($parameters)) {
                $parameters = [$parameters];
            }
        }
        return [$this->clauses['custom']['query'], $parameters];
    }
}
