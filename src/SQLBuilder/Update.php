<?php namespace MW\SQLBuilder;

use MW\SQLBuilder\Criteria\Criteria;
use MW\SQLBuilder\Traits\HasWhereClause;

class Update extends Query
{
    use HasWhereClause;
    
    protected $clauses = [
        'table' => '',
        'set' => [],
        'where' => []
    ];

    public function table($table)
    {
        $this->clauses['table'] = $table;
        return $this;
    }

    public function set(array $data)
    {
        foreach ($data as $key => $value) {
            $this->clauses['set'][$key] = $value;
        }
        return $this;
    }

    public function sql()
    {
        if (empty($this->clauses['table']) || empty($this->clauses['set'])) {
            return '';
        }
        
        return trim($this->tableClause() . $this->setClause() . $this->whereClause()); 
    }
    
    private function tableClause()
    {
        return "UPDATE {$this->clauses['table']} ";
    }
    
    private function setClause()
    {
        $strings = [];
        foreach ($this->clauses['set'] as $key => $value) {
            $strings[] = $this->addSetSql($key);
            $this->addSetParameter($value);
        }
        return 'SET ' . implode(', ', $strings) . ' ';
    }
    
    private function addSetSql($key)
    {
        return "$key=?";
    }
    
    private function addSetParameter($value)
    {
        $this->parameters[] = $value;
    }
}