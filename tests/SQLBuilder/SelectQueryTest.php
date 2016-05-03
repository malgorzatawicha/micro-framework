<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\Criteria\Equals;
use MW\SQLBuilder\SelectQuery;

class SelectTest extends \PHPUnit_Framework_TestCase
{
    private function classBuilder()
    {
        return new SelectQuery(new Connection());
    }
    
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilder\Select', $this->classBuilder());    
    }

    public function testSql()
    {
        $select = $this->classBuilder();
        $this->assertEquals('', $select->sql());
    }
    
    public function testAddingTable()
    {
        $select = $this->classBuilder();
        
        $select->table('products');
        
        $this->assertEquals('SELECT * FROM products', $select->sql());
    }
    
    public function testAddingTableAlias()
    {
        $select = $this->classBuilder();

        $select->table('products', 'p');

        $this->assertEquals('SELECT * FROM products AS p', $select->sql());  
    }
    
    public function testAddingSelect()
    {
        $select = $this->classBuilder();

        $select->table('products', 'p')
            ->select('p.name');

        $this->assertEquals('SELECT p.name FROM products AS p', $select->sql());
    }

    public function testAddingSelectWithAlias()
    {
        $select = $this->classBuilder();

        $select->table('products', 'p')
            ->select('p.name', 'product_name');

        $this->assertEquals('SELECT p.name AS product_name FROM products AS p', $select->sql());
    }

    public function testAddingMultiSelect()
    {
        $select = $this->classBuilder();

        $select->table('products', 'p')
            ->select(['p.name', 'p.model']);

        $this->assertEquals('SELECT p.name, p.model FROM products AS p', $select->sql());
    }

    public function testAddingMultiSelectWithAlias()
    {
        $select = $this->classBuilder();

        $select->table('products', 'p')
            ->select(['p.name' => 'product_name', 'p.model']);

        $this->assertEquals('SELECT p.name AS product_name, p.model FROM products AS p', $select->sql());
    }
    
    public function testWhere()
    {
        $select = $this->classBuilder();

        $select->table('products')
            ->where(new Equals('name', 'prod1'));

        $this->assertEquals('SELECT * FROM products WHERE name=?', $select->sql());
        $this->assertEquals(['prod1'], $select->parameters());
    }
}