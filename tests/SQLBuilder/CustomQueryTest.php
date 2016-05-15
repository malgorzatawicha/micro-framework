<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\CustomQuery;
use Tests\BaseTest;

class CustomQueryTest extends BaseTest
{
    private function classBuilder()
    {
        return new CustomQuery($this->getConnectionMock());
    }
    
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilder\CustomQuery', $this->classBuilder());    
    }

    public function testSql()
    {
        $query = $this->classBuilder();
        $this->assertEquals('', $query->sql());
    }

    public function testQuery()
    {
        $query = $this->classBuilder();

        $query->query('custom query');

        $this->assertEquals('custom query', $query->sql());
    }

    public function testQueryWithParams()
    {
        $query = $this->classBuilder();

        $query->query('custom query where name = ?', 'dummy');

        $this->assertEquals('custom query where name = ?', $query->sql());
        $this->assertEquals(['dummy'], $query->parameters());
    }
}
