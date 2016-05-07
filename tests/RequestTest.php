<?php namespace Tests;


use MW\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    private function createRequestObject($get = [], $post = [])
    {
        return new Request(['_GET' => $get, '_POST' => $post]);
    }
    public function testClassExists()
    {
        $request = new Request([]);
        $this->assertInstanceOf('\MW\Request', $request);
    }

    public function testHasGetParameter()
    {
        $request = $this->createRequestObject(['dummy' => 'existent']);
        $this->assertTrue($request->has('dummy'));
    }
    
    public function testHasNotGetParameter()
    {
        $request = $this->createRequestObject(['dummy' => 'existent']);
        $this->assertFalse($request->has('nonexistent'));
    }
    
    public function testGetParameter()
    {
        $request = $this->createRequestObject(['dummy' => 'existent'], ['dummy2' => 'existent2']);
        $this->assertEquals('existent', $request->dummy);
        $this->assertEquals('existent2', $request->dummy2);
    }

    public function testGetNonExistentParameter()
    {
        $request = $this->createRequestObject(['dummy' => 'existent'], ['dummy2' => 'existent2']);
        $this->assertNull($request->dummy3);
    }
}