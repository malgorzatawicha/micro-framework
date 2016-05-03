<?php namespace Tests;

use MW\Connection;
use MW\SQLBuilder;

class SQLBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testClassExists()
    {
        $class = new SQLBuilder(new Connection());
        $this->assertInstanceOf('\MW\SQLBuilder', $class);
    }
}