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

    /**
     * @return string
     */
    public function sql()
    {
        if (!empty($this->clauses['table']['name'])) {
            return trim($this->selectClause() . $this->tableClause() . $this->whereClause());
        }
        return '';
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
     * @param string $select
     * @param string $alias
     */
    private function addSelect($select, $alias = '') {
        $this->clauses['select'][$select] = $alias;
    }

    /**
     * @return string
     */
    private function selectClause()
    {
        if (empty($this->clauses['select'])) {
            return 'SELECT * ';
        }
        $strings = [];
        foreach ($this->clauses['select'] as $key => $value) {
            $strings[] = $key . (!empty($value)?" AS " . $value:"");
        }
        return 'SELECT ' . implode(', ', $strings) . ' ';
    }

    /**
     * @return string
     */
    private function tableClause()
    {
        return 'FROM ' . $this->clauses['table']['name'] . 
        (!empty($this->clauses['table']['alias'])?' AS ' . $this->clauses['table']['alias']: '') . ' ';
    }
    
}