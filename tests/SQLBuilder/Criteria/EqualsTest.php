<?php namespace Tests\SQLBuilder\Criteria;

use MW\SQLBuilder\Criteria\Equals;

class EqualsTest extends \PHPUnit_Framework_TestCase
{
    public function testClassExists()
    {
        $class = new Equals();
        $this->assertInstanceOf('\MW\SQLBuilder\Criteria\Equals', $class);
    }
    
    public function testSql()
    {
        $class = new Equals();
        $this->assertEquals('', $class->sql());
    }
    
    public function testEmptyValueSql()
    {
        $class = new Equals('name');
        $this->assertEquals('', $class->sql());
    }

    public function testSomeSql()
    {
        $class = new Equals('name', 'prod1');
        $this->assertEquals('name=?', $class->sql());
        $this->assertEquals(['prod1'], $class->parameters());
    }
}