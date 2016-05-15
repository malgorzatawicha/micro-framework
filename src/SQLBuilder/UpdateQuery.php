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
     * @return string
     */
    protected function tableClause()
    {
        return 'UPDATE ' . $this->clauses['table']. ' ';
    }

    /**
     * @param array $clause
     * @return array<string|array>
     */
    protected function setClause(array $clause)
    {
        $strings    = [];
        $parameters = [];
        foreach ($clause as $key => $value) {
            $strings[]    = $this->addSetSql($key);
            $parameters[] = $value;
        }
        return ['SET ' . implode(', ', $strings) . ' ', $parameters];
    }

    /**
     * @param $key
     * @return string
     */
    private function addSetSql($key)
    {
        return $key . '=?';
    }
}
