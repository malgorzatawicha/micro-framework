<?php namespace Tests;


use MW\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testClassExists()
    {
        $request = new Request([]);
        $this->assertInstanceOf('\MW\Request', $request);
    }
}