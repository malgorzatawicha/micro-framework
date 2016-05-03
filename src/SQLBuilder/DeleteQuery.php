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
     * @return string
     */
    public function sql()
    {
        if (empty($this->clauses['table'])) {
            return '';
        }

        return trim($this->tableClause() . $this->whereClause());
    }

    /**
     * @return string
     */
    private function tableClause()
    {
        return "DELETE FROM " . $this->clauses['table'] . " ";
    }
}