<?php namespace MW\SQLBuilder;

/**
 * Class CustomQuery
 * @package MW\SQLBuilder
 */
class CustomQuery extends Query
{
    protected $clauses = [
        'custom' => ''
    ];
    
    public function query($query, $parameters = null)
    {
        $this->clauses['custom'] = [
            'query' => $query,
            'parameters' => $parameters
        ];
    }

    protected function canBuildSql()
    {
        return !empty($this->clauses['custom']);
    }
    
    protected function customClause()
    {
        $this->parameters = null;
        if (!empty($this->clauses['custom']['parameters'])) {
            $parameters = $this->clauses['custom']['parameters'];
            if (!is_array($parameters)) {
                $parameters = [$parameters];
            }
            $this->parameters = $parameters;
        }
        return $this->clauses['custom']['query'];
    }
}
