<?php namespace MW\SQLBuilder;

class Insert extends Query
{
    protected $clauses = [
        'table' => '',
        'data' => [

        ]
    ];

    public function table($table)
    {
        $this->clauses['table'] = $table;
        return $this;
    }

    public function data(array $data) {

        if (is_numeric(key($data))) {
            return $this->multi($data);
        }
         
        $this->addData($data);
        return $this;
    }

    public function multi(array $data)
    {
        foreach ($data as $row) {
            $this->addData($row);
        }
        return $this;    
    }
    
    private function addData($data)
    {
        $this->clauses['data'][] = $data;
    }
    
    public function sql()
    {
        if (empty($this->clauses['table']) || empty($this->clauses['data'])) {
            return '';
        }
        return trim($this->tableClause() . $this->columnsClause() . $this->valuesClause());
    }

    private function tableClause()
    {
        return "INSERT INTO {$this->clauses['table']} ";
    }

    private function columnsClause()
    {
        $firstRow = reset($this->clauses['data']);
        return "(" . implode(', ', array_keys($firstRow)) . ") ";
    }

    private function valuesClause()
    {
        $result = [];
        foreach ($this->clauses['data'] as $row) {
            $result[] = $this->addRowSqlClause($row);
            $this->addRowParametersClause($row);
        }
        return "VALUES " . implode(', ', $result) . ' ';
    }

    private function addRowSqlClause($row)
    {
        $count = count(array_values($row));
        return "(" . implode(', ', array_fill(0, $count, '?')) . ")";
    }

    private function addRowParametersClause($row)
    {
        $this->parameters = array_merge($this->parameters, array_values($row));
    }
}