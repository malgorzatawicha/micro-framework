<?php namespace Tests;

use MW\SQLBuilder;

class SQLBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testClassExists()
    {
        $class = new SQLBuilder();
        $this->assertInstanceOf('\MW\SQLBuilder', $class);
    }
}