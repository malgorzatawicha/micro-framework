<?php namespace Tests;

use MW\Connection;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testClassExists()
    {
        $class = new Connection();
        $this->assertInstanceOf('\MW\Connection', $class);
    }
}