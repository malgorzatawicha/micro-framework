<?php namespace Tests;

use MW\Connection;
use MW\SQLBuilderFactory;

class SQLBuilderFactoryTest extends BaseTest
{
    private function buildClass()
    {
        return new SQLBuilderFactory($this->getConnectionMock());
    }
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilderFactory', $this->buildClass());
    }

    public function testBuildingSelectQuery()
    {
        $class = $this->buildClass();
        $this->assertInstanceOf('\MW\SQLBuilder\SelectQuery', $class->getSelectQuery());
    }


    public function testBuildingInsertQuery()
    {
        $class = $this->buildClass();
        $this->assertInstanceOf('\MW\SQLBuilder\InsertQuery', $class->getInsertQuery());
    }


    public function testBuildingUpdateQuery()
    {
        $class = $this->buildClass();
        $this->assertInstanceOf('\MW\SQLBuilder\UpdateQuery', $class->getUpdateQuery());
    }


    public function testBuildingDeleteQuery()
    {
        $class = $this->buildClass();
        $this->assertInstanceOf('\MW\SQLBuilder\DeleteQuery', $class->getDeleteQuery());
    }

    public function testBuildingCustomQuery()
    {
        $class = $this->buildClass();
        $this->assertInstanceOf('\MW\SQLBuilder\CustomQuery', $class->getCustomQuery());
    }

    public function testGettingConnection()
    {
        $class = $this->buildClass();
        $this->assertInstanceOf('\MW\Connection', $class->connection());
    }
}
