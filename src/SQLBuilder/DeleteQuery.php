<?php namespace MW\SQLBuilder;

use MW\SQLBuilder\Traits\HasWhereClause;

/**
 * Class DeleteQuery
 * @package MW\SQLBuilder
 */
class DeleteQuery extends Query
{
    use HasWhereClause;

    /**
     * @var array
     */
    protected $clauses = [
        'table' => '',
        'where' => []
    ];

    /**
     * @param string $table
     * @return $this
     */
    public function table($table)
    {
        $this->clauses['table'] = $table;
        return $this;
    }

    /**
     * @return bool
     */
    protected function canBuildSql()
    {
        return (!empty($this->clauses['table']));
    }

    /**
     * @return string
     */
    protected function tableClause()
    {
        return 'DELETE FROM ' . $this->clauses['table'] . ' ';
    }
}