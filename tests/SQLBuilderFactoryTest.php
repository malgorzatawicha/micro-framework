<?php namespace Tests;

use MW\Connection;
use MW\SQLBuilderFactory;

class SQLBuilderFactoryTest extends \PHPUnit_Framework_TestCase
{
    private function buildClass()
    {
        return new SQLBuilderFactory(new Connection());
    }
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilderFactory', $this->buildClass());
    }

    /**
     * @expectedException \MW\UnrecognizedSqlQueryTypeException
     */
    public function testThrowsExceptionIfThereIsWrongSqlQueryType()
    {
        $class = $this->buildClass();
        $class->newSqlBuilderInstance('');
    }
    
    public function testBuildingSelectQuery()
    {
        $class = $this->buildClass();
        $this->assertInstanceOf('\MW\SQLBuilder\Select', $class->newSqlBuilderInstance(SQLBuilderFactory::SELECT));
    }


    public function testBuildingInsertQuery()
    {
        $class = $this->buildClass();
        $this->assertInstanceOf('\MW\SQLBuilder\Insert', $class->newSqlBuilderInstance(SQLBuilderFactory::INSERT));
    }


    public function testBuildingUpdateQuery()
    {
        $class = $this->buildClass();
        $this->assertInstanceOf('\MW\SQLBuilder\Update', $class->newSqlBuilderInstance(SQLBuilderFactory::UPDATE));
    }


    public function testBuildingDeleteQuery()
    {
        $class = $this->buildClass();
        $this->assertInstanceOf('\MW\SQLBuilder\Delete', $class->newSqlBuilderInstance(SQLBuilderFactory::DELETE));
    }
}