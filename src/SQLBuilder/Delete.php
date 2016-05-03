<?php namespace MW\SQLBuilder;

class Delete extends Query
{
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

        return trim($this->tableClause());
    }

    private function tableClause()
    {
        return "DELETE FROM {$this->clauses['table']}";
    }
}