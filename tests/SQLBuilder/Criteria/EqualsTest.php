<?php namespace Tests\SQLBuilder\Criteria;

use MW\SQLBuilder\Criteria\Equals;
use Tests\BaseTest;

class EqualsTest extends BaseTest
{
    public function testClassExists()
    {
        $class = new Equals($this->getConnectionMock());
        $this->assertInstanceOf('\MW\SQLBuilder\Criteria\Equals', $class);
    }
    
    public function testSql()
    {
        $class = new Equals($this->getConnectionMock());
        $this->assertEquals('', $class->sql());
    }
    
    public function testEmptyValueSql()
    {
        $class = new Equals($this->getConnectionMock(), 'name');
        $this->assertEquals('', $class->sql());
    }

    public function testSomeSql()
    {
        $connectionMock = $this->getConnectionMock();
        $connectionMock->expects($this->once())->method('escapeName')->with('name')->willReturn('`name`');
        
        $class = new Equals($connectionMock, 'name', 'prod1');
        $this->assertEquals('`name`=?', $class->sql());
        $this->assertEquals(['prod1'], $class->parameters());
    }
}
