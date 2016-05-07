<?php namespace Tests;


use MW\Request;

class RequestTest extends BaseTest
{
    public function testClassExists()
    {
        $request = new Request($this->getRequestValueMock());
        $this->assertInstanceOf('\MW\Request', $request);
    }

    public function testHasGetParameter()
    {
        $mock = $this->getRequestValueMock();
        $mock->expects($this->once())->method('get')->willReturn(['dummy' => 'existent']);
        $mock->expects($this->once())->method('post')->willReturn([]);
        
        $request = new Request($mock);
        $this->assertTrue($request->has('dummy'));
    }
    
    public function testHasNotGetParameter()
    {
        $mock = $this->getRequestValueMock();
        $mock->expects($this->once())->method('get')->willReturn(['dummy' => 'existent']);
        $mock->expects($this->once())->method('post')->willReturn([]);

        $request = new Request($mock);
        $this->assertFalse($request->has('nonexistent'));
    }
    
    public function testGetParameter()
    {
        $mock = $this->getRequestValueMock();
        $mock->expects($this->exactly(2))->method('get')->willReturn(['dummy' => 'existent']);
        $mock->expects($this->exactly(2))->method('post')->willReturn(['dummy2' => 'existent2']);

        $request = new Request($mock);
        $this->assertEquals('existent', $request->dummy);
        $this->assertEquals('existent2', $request->dummy2);
    }

    public function testGetNonExistentParameter()
    {
        $mock = $this->getRequestValueMock();
        $mock->expects($this->once())->method('get')->willReturn(['dummy' => 'existent']);
        $mock->expects($this->once())->method('post')->willReturn(['dummy2' => 'existent2']);

        $request = new Request($mock);
        $this->assertNull($request->dummy3);
    }

    public function testGetUri()
    {
        $mock = $this->getRequestValueMock();
        $mock->expects($this->once())->method('requestUri')->willReturn('dummy');

        $request = new Request($mock);
        $this->assertEquals('dummy', $request->getUri());
    }

    public function testGetUriWithSlashAtEnd()
    {
        $mock = $this->getRequestValueMock();
        $mock->expects($this->once())->method('requestUri')->willReturn('dummy/');

        $request = new Request($mock);
        $this->assertEquals('dummy', $request->getUri());
    }

    public function testGetUriWithSlashAtStart()
    {
        $mock = $this->getRequestValueMock();
        $mock->expects($this->once())->method('requestUri')->willReturn('/dummy/');

        $request = new Request($mock);
        $this->assertEquals('dummy', $request->getUri());
    }
}