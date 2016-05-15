<?php namespace MW\SQLBuilder;

/**
 * Class InsertQuery
 * @package MW\SQLBuilder
 */
class InsertQuery extends Query
{
    /**
     * @var array
     */
    protected $clauses = [
        'table' => '',
        'data' => [
        ]
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
     * @param array $data
     * @return $this
     */
    public function data(array $data)
    {

        if (is_numeric(key($data))) {
            return $this->multi($data);
        }

        $this->addData($data);
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function multi(array $data)
    {
        foreach ($data as $row) {
            $this->addData($row);
        }
        return $this;
    }

    public function insert()
    {
        return $this->connection->insert($this->sql(), $this->parameters());
    }
    
    /**
     * @param array $data
     */
    private function addData(array $data)
    {
        $this->clauses['data'][] = $data;
    }

    /**
     * @return bool
     */
    protected function canBuildSql()
    {
        return (!empty($this->clauses['table']) && !empty($this->clauses['data']));
    }

    /**
     * @return string
     */
    protected function dataClause() 
    {
        return $this->columnsClause() . $this->valuesClause();
    }
    
    /**
     * @return string
     */
    protected function tableClause()
    {
        return 'INSERT INTO ' . $this->clauses['table'] . ' ';
    }

    /**
     * @return string
     */
    protected function columnsClause()
    {
        $firstRow = reset($this->clauses['data']);
        return '(' . implode(', ', array_keys($firstRow)) . ') ';
    }

    /**
     * @return string
     */
    protected function valuesClause()
    {
        $result = [];
        foreach ($this->clauses['data'] as $row) {
            $result[] = $this->addRowSqlClause($row);
            $this->addRowParametersClause($row);
        }
        return 'VALUES ' . implode(', ', $result) . ' ';
    }

    /**
     * @param array $row
     * @return string
     */
    private function addRowSqlClause($row)
    {
        $count = count(array_values($row));
        return '(' . implode(', ', array_fill(0, $count, '?')) . ')';
    }

    /**
     * @param array $row
     */
    private function addRowParametersClause($row)
    {
        $this->parameters = array_merge($this->parameters, array_values($row));
    }
}
