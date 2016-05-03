<?php namespace MW\SQLBuilder;

use MW\SQLBuilder\Traits\HasWhereClause;

class Delete extends Query
{
    use HasWhereClause;
    
    protected $clauses = [
        'table' => '',
        'where' => []
    ];

    public function table($table)
    {
        $this->clauses['table'] = $table;
        return $this;
    }

    public function sql()
    {
        if (empty($this->clauses['table'])) {
            return '';
        }

        return trim($this->tableClause() . $this->whereClause());
    }

    private function tableClause()
    {
        return "DELETE FROM {$this->clauses['table']} ";
    }
}