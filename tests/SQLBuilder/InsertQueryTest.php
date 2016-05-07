<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\InsertQuery;
use Tests\BaseTest;

class InsertTest extends BaseTest
{
    private function classBuilder()
    {
        return new InsertQuery(new Connection());
    }
    
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilder\InsertQuery', $this->classBuilder());    
    }

    public function testSql()
    {
        $query = $this->classBuilder();
        $this->assertEquals('', $query->sql());
    }
    
    public function testAddingTable()
    {
        $query = $this->classBuilder();
        $query->table('products');
        $this->assertEquals('', $query->sql());
    }

    public function testAddingTableAndData()
    {
        $query = $this->classBuilder();
        $query->table('products')
            ->data(['name' => 'prod1', 'model' => 'm1']);
        $this->assertEquals('INSERT INTO products (name, model) VALUES (?, ?)', $query->sql());
        $this->assertEquals(['prod1', 'm1'], $query->parameters());
    }
    
    public function testAddingMultiData()
    {
        $query = $this->classBuilder();
        $query->table('products')
            ->data([['name' => 'prod1', 'model' => 'm1'], ['name' => 'prod2', 'model' => 'm2']]);
        $this->assertEquals('INSERT INTO products (name, model) VALUES (?, ?), (?, ?)', $query->sql());
        $this->assertEquals(['prod1', 'm1', 'prod2', 'm2'], $query->parameters());
    }

    public function testAddingMultiData2()
    {
        $query = $this->classBuilder();
        $query->table('products')
            ->multi([['name' => 'prod1', 'model' => 'm1'], ['name' => 'prod2', 'model' => 'm2']]);
        $this->assertEquals('INSERT INTO products (name, model) VALUES (?, ?), (?, ?)', $query->sql());
        $this->assertEquals(['prod1', 'm1', 'prod2', 'm2'], $query->parameters());
    }
}