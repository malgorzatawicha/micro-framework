<?php namespace MW\SQLBuilder;

class Select extends Query
{
    private $clauses = [
        'select' => [],
        'table' => ['name' => '', 'alias' => ''],
        'where' => []
    ];
    public function sql()
    {
        if (!empty($this->clauses['table']['name'])) {
            return trim($this->selectClause() . $this->tableClause());
        }
        return '';
    }
    
    public function table($tableName, $tableAlias = '')
    {
        $this->clauses['table'] = [
            'name' => $tableName,
            'alias' => $tableAlias
        ];
    }
    
    private function selectClause()
    {
        if (empty($this->clauses['select'])) {
            return 'SELECT * ';
        }
        return 'SELECT ' . implode(', ', $this->clauses['select']) . ' ';
    }
    
    private function tableClause()
    {
        return 'FROM ' . $this->clauses['table']['name'] . 
        (!empty($this->clauses['table']['alias'])?' AS ' . $this->clauses['table']['alias'] . ' ': '');
    }
}