<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\Select;

class SelectTest extends \PHPUnit_Framework_TestCase
{
    private function classBuilder()
    {
        return new Select(new Connection());
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
}