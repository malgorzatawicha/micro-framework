<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\Criteria\Equals;
use MW\SQLBuilder\DeleteQuery;
use Tests\BaseTest;

class DeleteQueryTest extends BaseTest
{
    private function classBuilder($mock, $parameters = [])
    {
        foreach ($parameters as $key => $value) {
            $mock->expects($this->at($key))->method('escapeName')->with($value)->willReturn('`' . $value . '`');
        }
        return new DeleteQuery($mock);
    }
    
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilder\DeleteQuery', $this->classBuilder($this->getConnectionMock()));    
    }

    public function testSql()
    {
        $connectionMock = $this->getConnectionMock();
        $query = $this->classBuilder($connectionMock);
        $this->assertEquals('', $query->sql());
    }

    public function testAddingTable()
    {
        $connectionMock = $this->getConnectionMock();
        $query = $this->classBuilder($connectionMock, ['products']);
        
        $query->table('products');

        $this->assertEquals('DELETE FROM `products`', $query->sql());
    }

    public function testWhere()
    {
        $connectionMock = $this->getConnectionMock();
        $query = $this->classBuilder($connectionMock, ['products', 'name']);
        
        $query->table('products')
            ->where(new Equals($connectionMock, 'name', 'prod1'));

        $this->assertEquals('DELETE FROM `products` WHERE `name`=?', $query->sql());
        $this->assertEquals(['prod1'], $query->parameters());
    }
}
