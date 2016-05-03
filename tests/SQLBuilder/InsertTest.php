<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\Insert;

class InsertTest extends \PHPUnit_Framework_TestCase
{
    private function classBuilder()
    {
        return new Insert(new Connection());
    }
    
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilder\Insert', $this->classBuilder());    
    }

    public function testSql()
    {
        $query = $this->classBuilder();
        $this->assertEquals('', $query->sql());
    }
}