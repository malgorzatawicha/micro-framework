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
}