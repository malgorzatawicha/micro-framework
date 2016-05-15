<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\Criteria\Equals;
use MW\SQLBuilder\UpdateQuery;
use Tests\BaseTest;

class UpdateQueryTest extends BaseTest
{
    private function classBuilder($mock, $parameters = [])
    {
        foreach ($parameters as $key => $value) {
            $mock->expects($this->at($key))->method('escapeName')->with($value)->willReturn('`' . $value . '`');    
        }
        return new UpdateQuery($mock);
    }
    
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilder\UpdateQuery', $this->classBuilder($this->getConnectionMock()));    
    }

    public function testSql()
    {
        $query = $this->classBuilder($this->getConnectionMock());
        $this->assertEquals('', $query->sql());
    }
    
    public function testAddingTableAndSet()
    {
        $query = $this->classBuilder($this->getConnectionMock(), ['products', 'name']);
        
        $query->table('products')->set(['name' => 'prod1']);
        
        $this->assertEquals('UPDATE `products` SET `name`=?', $query->sql());
        $this->assertEquals(['prod1'], $query->parameters());
    }

    public function testAddingTableAndMultiSet()
    {
        $query = $this->classBuilder($this->getConnectionMock(), ['products', 'name', 'model']);

        $query->table('products')->set(['name' => 'prod1', 'model' => 'm1']);

        $this->assertEquals('UPDATE `products` SET `name`=?, `model`=?', $query->sql());
        $this->assertEquals(['prod1', 'm1'], $query->parameters());
    }

    public function testWhere()
    {
        $connectionMock = $this->getConnectionMock();
        $query = $this->classBuilder($connectionMock, ['products', 'model', 'name']);

        $query->table('products')
            ->set(['model' => 'm1'])
            ->where(new Equals($connectionMock, 'name', 'prod1'));

        $this->assertEquals('UPDATE `products` SET `model`=? WHERE `name`=?', $query->sql());
        $this->assertEquals(['m1', 'prod1'], $query->parameters());
    }

    public function testUpdate()
    {
        $connectionMock = $this->getConnectionMock();
        
        $connectionMock->expects($this->at(0))->method('escapeName')->with('products')->willReturn('`products`');
        $connectionMock->expects($this->at(1))->method('escapeName')->with('model')->willReturn('`model`');
        $connectionMock->expects($this->at(2))->method('escapeName')->with('name')->willReturn('`name`');
        
        $connectionMock->expects($this->once())
            ->method('execute')->with('UPDATE `products` SET `model`=? WHERE `name`=?', ['m1', 'prod1'])
            ->willReturn(true);

        $query = new UpdateQuery($connectionMock);

        $query->table('products')
            ->set(['model' => 'm1'])
            ->where(new Equals($connectionMock, 'name', 'prod1'));

        $this->assertTrue($query->execute());
    }
}
