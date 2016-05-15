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

    /**
     * @return string
     */
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
     * @param array $clause
     * @return array
     */
    protected function dataClause(array $clause) 
    {
        $columnsClause    = $this->columnsClause($clause);
        $valuesClause     = $this->valuesClause($clause);
        $valuesSql        = array_shift($valuesClause);
        $valuesParameters = array_shift($valuesClause);
        return [$columnsClause . $valuesSql, $valuesParameters];
    }
    
    /**
     * @param string $clause
     * @return string
     */
    protected function tableClause($clause)
    {
        return 'INSERT INTO ' . $this->connection->escapeName($clause) . ' ';
    }

    /**
     * @param array $clause
     * @return string
     */
    protected function columnsClause(array $clause)
    {
        return '(' . implode(', ', $this->escapeNames(array_keys(reset($clause)))) . ') ';
    }

    /**
     * @param array $clause
     * @return array<string|array>
     */
    protected function valuesClause(array $clause)
    {
        return [
            'VALUES ' . $this->collectValueSqls($clause),
            $this->collectValueParameters($clause)
        ];
    }

    /**
     * @param array $clause
     * @return string
     */
    private function collectValueSqls(array $clause)
    {
        $result = [];
        foreach ($clause as $row) {
            $result[] = $this->addValueSql($row);
        }
        return implode(', ', $result);
    }

    /**
     * @param array $clause
     * @return array
     */
    private function collectValueParameters(array $clause)
    {
        $result = [];
        foreach ($clause as $row) {
            $result = array_merge($result, array_values($row));
        }
        return $result;
    }
    
    /**
     * @param array $row
     * @return string
     */
    private function addValueSql($row)
    {
        $count = count(array_values($row));
        return '(' . implode(', ', array_fill(0, $count, '?')) . ')';
    }
}
