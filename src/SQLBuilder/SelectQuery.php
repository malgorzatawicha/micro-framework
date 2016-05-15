<?php namespace MW\SQLBuilder;

use MW\SQLBuilder\Traits\HasWhereClause;

/**
 * Class SelectQuery
 * @package MW\SQLBuilder
 */
class SelectQuery extends Query
{
    use HasWhereClause;

    /**
     * @var array
     */
    protected $clauses = [
        'select' => [],
        'table' => ['name' => '', 'alias' => ''],
        'where' => []
    ];

    protected function canBuildSql()
    {
        return !empty($this->clauses['table']['name']);
    }

    /**
     * @param string $tableName
     * @param string $tableAlias
     * @return $this
     */
    public function table($tableName, $tableAlias = '')
    {
        $this->clauses['table'] = [
            'name' => $tableName,
            'alias' => $tableAlias
        ];
        return $this;
    }

    /**
     * @param string|array $select
     * @param string $alias
     * @return $this
     */
    public function select($select, $alias = '')
    {
        if (is_array($select)) {
            foreach ($select as $key => $value) {
                if (is_numeric($key)) {
                    $this->addSelect($value);
                } else {
                    $this->addSelect($key, $value);
                }
            }
        } else {
            $this->addSelect($select, $alias);
        }
        return $this;
    }

    /**
     * @return array|null
     */
    public function first()
    {
        return $this->connection->fetch($this->sql(), $this->parameters());
    }

    /**
     * @return array|null
     */
    public function all()
    {
        return $this->connection->fetchAll($this->sql(), $this->parameters());
    }
    
    /**
     * @param string $select
     * @param string $alias
     */
    private function addSelect($select, $alias = '') {
        $this->clauses['select'][$select] = $alias;
    }

    /**
     * @param array $clause
     * @return string
     */
    protected function selectClause(array $clause)
    {
        if (empty($clause)) {
            return 'SELECT * ';
        }
        $strings = [];
        foreach ($clause as $key => $value) {
            $strings[] = $key . (!empty($value)?' AS ' . $value:'');
        }
        return 'SELECT ' . implode(', ', $strings) . ' ';
    }

    /**
     * @param array $clause
     * @return string
     */
    protected function tableClause(array $clause)
    {
        return 'FROM ' . $clause['name'] . 
        (!empty($clause['alias'])?' AS ' . $clause['alias']: '') . ' ';
    }
    
}
