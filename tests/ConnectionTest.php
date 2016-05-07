<?php namespace Tests;

use MW\Connection;

class ConnectionTest extends BaseTest
{
    public function testClassExists()
    {
        $class = new Connection();
        $this->assertInstanceOf('\MW\Connection', $class);
    }
}