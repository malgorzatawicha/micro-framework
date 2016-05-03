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
     * @return string
     */
    public function sql()
    {
        if (empty($this->clauses['table']) || empty($this->clauses['set'])) {
            return '';
        }
        
        return trim($this->tableClause() . $this->setClause() . $this->whereClause()); 
    }

    /**
     * @return string
     */
    private function tableClause()
    {
        return "UPDATE " . $this->clauses['table']. " ";
    }

    /**
     * @return string
     */
    private function setClause()
    {
        $strings = [];
        foreach ($this->clauses['set'] as $key => $value) {
            $strings[] = $this->addSetSql($key);
            $this->addSetParameter($value);
        }
        return 'SET ' . implode(', ', $strings) . ' ';
    }

    /**
     * @param $key
     * @return string
     */
    private function addSetSql($key)
    {
        return $key . "=?";
    }

    /**
     * @param mixed $value
     */
    private function addSetParameter($value)
    {
        $this->parameters[] = $value;
    }
}