<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\InsertQuery;
use Tests\BaseTest;

class InsertQueryTest extends BaseTest
{
    private function classBuilder($mock, $parameters = [])
    {
        foreach ($parameters as $key => $value) {
            $mock->expects($this->at($key))->method('escapeName')->with($value)->willReturn('`' . $value . '`');
        }
        return new InsertQuery($mock);
    }
    
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilder\InsertQuery', $this->classBuilder($this->getConnectionMock()));    
    }

    public function testSql()
    {
        $query = $this->classBuilder($this->getConnectionMock());
        $this->assertEquals('', $query->sql());
    }
    
    public function testAddingTable()
    {
        $query = $this->classBuilder($this->getConnectionMock());
        $query->table('products');
        $this->assertEquals('', $query->sql());
    }

    public function testAddingTableAndData()
    {
        $query = $this->classBuilder($this->getConnectionMock(), ['products', 'name', 'model']);
        $query->table('products')
            ->data(['name' => 'prod1', 'model' => 'm1']);
        $this->assertEquals('INSERT INTO `products` (`name`, `model`) VALUES (?, ?)', $query->sql());
        $this->assertEquals(['prod1', 'm1'], $query->parameters());
    }
    
    public function testAddingMultiData()
    {
        $query = $this->classBuilder($this->getConnectionMock(), ['products', 'name', 'model']);
        $query->table('products')
            ->data([['name' => 'prod1', 'model' => 'm1'], ['name' => 'prod2', 'model' => 'm2']]);
        $this->assertEquals('INSERT INTO `products` (`name`, `model`) VALUES (?, ?), (?, ?)', $query->sql());
        $this->assertEquals(['prod1', 'm1', 'prod2', 'm2'], $query->parameters());
    }

    public function testAddingMultiData2()
    {
        $query = $this->classBuilder($this->getConnectionMock(), ['products', 'name', 'model']);
        $query->table('products')
            ->multi([['name' => 'prod1', 'model' => 'm1'], ['name' => 'prod2', 'model' => 'm2']]);
        $this->assertEquals('INSERT INTO `products` (`name`, `model`) VALUES (?, ?), (?, ?)', $query->sql());
        $this->assertEquals(['prod1', 'm1', 'prod2', 'm2'], $query->parameters());
    }

    public function testInsertWithParameters()
    {
        $connectionMock = $this->getConnectionMock();
        $connectionMock->expects($this->once())
            ->method('insert')->with('INSERT INTO `products` (`name`, `model`) VALUES (?, ?)', ['prod1', 'm1'])
            ->willReturn(true);

        $query = $this->classBuilder($connectionMock, ['products', 'name', 'model']);

        $query->table('products')
            ->data(['name' => 'prod1', 'model' => 'm1']);

        $this->assertTrue($query->insert());
    }
}
