<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\Criteria\Equals;
use MW\SQLBuilder\UpdateQuery;
use Tests\BaseTest;

class UpdateTest extends BaseTest
{
    private function classBuilder()
    {
        return new UpdateQuery($this->getConnectionMock());
    }
    
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilder\UpdateQuery', $this->classBuilder());    
    }

    public function testSql()
    {
        $query = $this->classBuilder();
        $this->assertEquals('', $query->sql());
    }
    
    public function testAddingTableAndSet()
    {
        $query = $this->classBuilder();
        
        $query->table('products')->set(['name' => 'prod1']);
        
        $this->assertEquals('UPDATE products SET name=?', $query->sql());
        $this->assertEquals(['prod1'], $query->parameters());
    }

    public function testAddingTableAndMultiSet()
    {
        $query = $this->classBuilder();

        $query->table('products')->set(['name' => 'prod1', 'model' => 'm1']);

        $this->assertEquals('UPDATE products SET name=?, model=?', $query->sql());
        $this->assertEquals(['prod1', 'm1'], $query->parameters());
    }

    public function testWhere()
    {
        $query = $this->classBuilder();

        $query->table('products')
            ->set(['model' => 'm1'])
            ->where(new Equals('name', 'prod1'));

        $this->assertEquals('UPDATE products SET model=? WHERE name=?', $query->sql());
        $this->assertEquals(['m1', 'prod1'], $query->parameters());
    }
}
