<?php namespace Tests;


use MW\Router;

class RouterTest extends BaseTest
{
    private function getRouteMock($match, $controller)
    {
        $mock = $this->getMockBuilder('\MW\Route')
            ->setConstructorArgs(['pattern' => '', 'controller' => $controller])
            ->setMethods(['match'])
            ->getMock();

        $mock->expects($this->once())->method('match')->willReturn($match);
        
        return $mock;
    }
    
    public function testClassExists()
    {
        $router = new Router([]);
        $this->assertInstanceOf('\MW\Router', $router);
    }

    public function testMatchTrue()
    {
        $router = new Router([
            $this->getRouteMock(false, 'dummyController'),
            $this->getRouteMock(true, 'testController'),
        ]);

        $result = $router->execute($this->getRequestMock());
        
        $this->assertEquals('testController', $result->getControllerClass());
    }

    public function testMatchFalse()
    {
        $router = new Router([
            $this->getRouteMock(false, 'dummyController'),
            $this->getRouteMock(false, 'testController'),
        ]);

        $result = $router->execute($this->getRequestMock());

        $this->assertNull($result);
    }
}