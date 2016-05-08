<?php namespace Tests;


use MW\Router;

class RouterTest extends BaseTest
{
    public function testClassExists()
    {
        $router = new Router([]);
        $this->assertInstanceOf('\MW\Router', $router);
    }

    public function testMatchTrue()
    {
        $router = new Router([
            'dummyUrl' => 'dummyController'
        ]);
        
        $request = $this->getRequestMock();
        $request->expects($this->once())->method('getUri')->willReturn('dummyUrl');
        
        $result = $router->execute($request);
        
        $this->assertEquals('dummyController', $result);
    }

    public function testMatchFalse()
    {
        $router = new Router([
            'dummy2Url' => 'dummy2Controller'
        ]);
        
        $request = $this->getRequestMock();
        $request->expects($this->once())->method('getUri')->willReturn('dummyUrl');
        
        $result = $router->execute($request);
        $this->assertNull($result);
    }

    public function testHttpGetMethodMatchTrue()
    {
        $router = new Router([
            'get@dummyUrl' => 'dummyController'
        ]);
        
        $request = $this->getRequestMock();
        $request->expects($this->once())->method('getUri')->willReturn('dummyUrl');
        $request->expects($this->once())->method('isGet')->willReturn(true);

        $result = $router->execute($request);

        $this->assertEquals('dummyController', $result);
    }

    public function testHttpGetMethodMatchFalse()
    {
        $router = new Router([
            'get@dummyUrl' => 'dummyController'
        ]);
        
        $request = $this->getRequestMock();
        $request->expects($this->never())->method('getUri');
        $request->expects($this->once())->method('isGet')->willReturn(false);

        $result = $router->execute($request);

        $this->assertNull($result);
    }

    public function testNonExistingHttpMethodMatchFalse()
    {
        $router = new Router([
            'nonExisting@dummyUrl' => 'dummyController'
        ]);

        $request = $this->getRequestMock();
        $request->expects($this->never())->method('getUri');

        $result = $router->execute($request);

        $this->assertNull($result);
    }
}
