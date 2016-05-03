<?php namespace Tests;

use MW\Connection;
use MW\SQLBuilderFactory;

class SQLBuilderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testClassExists()
    {
        $class = new SQLBuilderFactory(new Connection());
        $this->assertInstanceOf('\MW\SQLBuilderFactory', $class);
    }
}