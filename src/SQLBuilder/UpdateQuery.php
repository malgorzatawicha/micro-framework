<?php namespace MW\SQLBuilder;

use MW\SQLBuilder\Traits\HasWhereClause;

/**
 * Class UpdateQuery
 * @package MW\SQLBuilder
 */
class UpdateQuery extends Query
{
    use HasWhereClause;

    /**
     * @var array
     */
    protected $clauses = [
        'table' => '',
        'set' => [],
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
     * @param array $data
     * @return $this
     */
    public function set(array $data)
    {
        foreach ($data as $key => $value) {
            $this->clauses['set'][$key] = $value;
        }
        return $this;
    }

    /**
     * @return bool
     */
    protected function canBuildSql()
    {
        return (!empty($this->clauses['table']) && !empty($this->clauses['set']));
    }

    /**
     * @param string $clause
     * @return string
     */
    protected function tableClause($clause)
    {
        return 'UPDATE ' . $this->connection->escapeName($clause). ' ';
    }

    /**
     * @param array $clause
     * @return array<string|array>
     */
    protected function setClause(array $clause)
    {
        return [
            'SET ' . $this->collectSetSqls($clause) . ' ',
            $this->collectSetParameters($clause)
        ];
    }

    /**
     * @param array $clause
     * @return string
     */
    private function collectSetSqls(array $clause) 
    {
        $result = [];
        foreach (array_keys($clause) as $columnName) {
            $result[] = $this->addSetSql($columnName);
        }
        return implode(', ', $result);
    }

    /**
     * @param array $clause
     * @return array
     */
    private function collectSetParameters(array $clause)
    {
        return array_values($clause);
    }
    
    /**
     * @param $key
     * @return string
     */
    private function addSetSql($key)
    {
        return $this->connection->escapeName($key) . '=?';
    }
}
