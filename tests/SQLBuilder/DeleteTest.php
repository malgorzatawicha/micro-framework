<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\Delete;

class DeleteTest extends \PHPUnit_Framework_TestCase
{
    private function classBuilder()
    {
        return new Delete(new Connection());
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
}