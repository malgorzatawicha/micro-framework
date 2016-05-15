<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\Criteria\Equals;
use MW\SQLBuilder\SelectQuery;
use Tests\BaseTest;

class SelectQueryTest extends BaseTest
{
    private function classBuilder($mock, $parameters = [])
    {
        foreach ($parameters as $key => $value) {
            $mock->expects($this->at($key))->method('escapeName')->with($value)->willReturn('`' . $value . '`');
        }
        return new SelectQuery($mock);
    }
    
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilder\SelectQuery', $this->classBuilder($this->getConnectionMock()));    
    }

    public function testSql()
    {
        $select = $this->classBuilder($this->getConnectionMock());
        $this->assertEquals('', $select->sql());
    }
    
    public function testAddingTable()
    {
        $select = $this->classBuilder($this->getConnectionMock(), ['products']);
        
        $select->table('products');
        
        $this->assertEquals('SELECT * FROM `products`', $select->sql());
    }
    
    public function testAddingTableAlias()
    {
        $select = $this->classBuilder($this->getConnectionMock(), ['products', 'p']);

        $select->table('products', 'p');

        $this->assertEquals('SELECT * FROM `products` AS `p`', $select->sql());  
    }
    
    public function testAddingSelect()
    {
        $select = $this->classBuilder($this->getConnectionMock(), ['p', 'name', 'products', 'p']);

        $select->table('products', 'p')
            ->select('p.name');

        $this->assertEquals('SELECT `p`.`name` FROM `products` AS `p`', $select->sql());
    }

    public function testAddingSelectWithAlias()
    {
        $select = $this->classBuilder($this->getConnectionMock(), ['p', 'name', 'product_name', 'products', 'p']);

        $select->table('products', 'p')
            ->select('p.name', 'product_name');

        $this->assertEquals('SELECT `p`.`name` AS `product_name` FROM `products` AS `p`', $select->sql());
    }

    public function testAddingMultiSelect()
    {
        $select = $this->classBuilder($this->getConnectionMock(),
            ['p', 'name', 'p', 'model', 'products', 'p']);

        $select->table('products', 'p')
            ->select(['p.name', 'p.model']);

        $this->assertEquals('SELECT `p`.`name`, `p`.`model` FROM `products` AS `p`', $select->sql());
    }

    public function testAddingMultiSelectWithAlias()
    {
        $select = $this->classBuilder($this->getConnectionMock(),
        ['p', 'name', 'product_name', 'p', 'model', 'products', 'p']);

        $select->table('products', 'p')
            ->select(['p.name' => 'product_name', 'p.model']);

        $this->assertEquals('SELECT `p`.`name` AS `product_name`, `p`.`model` FROM `products` AS `p`', $select->sql());
    }
    
    public function testWhere()
    {
        $connectionMock = $this->getConnectionMock();
        $select = $this->classBuilder($connectionMock, ['products', 'name']);

        $select->table('products')
            ->where(new Equals($connectionMock, 'name', 'prod1'));

        $this->assertEquals('SELECT * FROM `products` WHERE `name`=?', $select->sql());
        $this->assertEquals(['prod1'], $select->parameters());
    }
    
    public function testFirst()
    {
        $connectionMock = $this->getConnectionMock();
        $connectionMock->expects($this->once())
            ->method('fetch')->with('SELECT * FROM `products` WHERE `name`=?', ['prod1'])
            ->willReturn(['name' => 'prod1']);
        
        $select = $this->classBuilder($connectionMock, ['products', 'name']);
        $select->table('products')
            ->where(new Equals($connectionMock, 'name', 'prod1'));

        $this->assertEquals(['name' => 'prod1'], $select->first());
    }

    public function testAll()
    {
        $connectionMock = $this->getConnectionMock();
        $connectionMock->expects($this->once())
            ->method('fetchAll')->with('SELECT * FROM `products` WHERE `name`=?', ['prod1'])
            ->willReturn([['name' => 'prod1']]);

        $select = $this->classBuilder($connectionMock, ['products', 'name']);
        $select->table('products')
            ->where(new Equals($connectionMock, 'name', 'prod1'));

        $this->assertEquals([['name' => 'prod1']], $select->all());
    }
}
