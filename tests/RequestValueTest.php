<?php namespace Tests;


use MW\RequestValue;

class RequestValueTest extends BaseTest
{
    public function testClassExists()
    {
        $request = new RequestValue([]);
        $this->assertInstanceOf('\MW\RequestValue', $request);
    }

    public function testEmptyGet()
    {
        $request = new RequestValue([]);
        $this->assertEquals([], $request->get());
    }
    
    public function testGet()
    {
        $request = new RequestValue(['_GET' => ['dummy1' => 'existent1']]);
        $this->assertEquals(['dummy1' => 'existent1'], $request->get());
    }

    public function testEmptyPost()
    {
        $request = new RequestValue([]);
        $this->assertEquals([], $request->post());
    }

    
    public function testPost()
    {
        $request = new RequestValue(['_POST' => ['dummy1' => 'existent1']]);
        $this->assertEquals(['dummy1' => 'existent1'], $request->post());
    }

    public function testEmptyServerRequestUri()
    {
        $request = new RequestValue([]);
        $this->assertEquals('', $request->requestUri());
    }

    public function testEmptyRequestUri()
    {
        $request = new RequestValue(['_SERVER' => ['dummy1' => 'existent1']]);
        $this->assertEquals('', $request->requestUri());
    }

    public function testRequestUri()
    {
        $request = new RequestValue(['_SERVER' => ['REQUEST_URI' => 'dummy']]);
        $this->assertEquals('dummy', $request->requestUri());
    }
}