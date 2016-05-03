<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\Criteria\Equals;
use MW\SQLBuilder\DeleteQuery;

class DeleteTest extends \PHPUnit_Framework_TestCase
{
    private function classBuilder()
    {
        return new DeleteQuery(new Connection());
    }
    
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilder\Delete', $this->classBuilder());    
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

        $this->assertEquals('DELETE FROM products', $query->sql());
    }

    public function testWhere()
    {
        $query = $this->classBuilder();

        $query->table('products')
            ->where(new Equals('name', 'prod1'));

        $this->assertEquals('DELETE FROM products WHERE name=?', $query->sql());
        $this->assertEquals(['prod1'], $query->parameters());
    }
}