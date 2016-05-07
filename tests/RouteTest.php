<?php namespace Tests;


use MW\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    
    private function getRequestMock($uri = '')
    {
        $mock = $this->getMockBuilder('\MW\Request')
            ->setConstructorArgs(['requestValue' => $this->getMockBuilder('\MW\RequestValue')->getMock()])
            ->setMethods(['getUri'])
            ->getMock();

        $mock->expects($this->once())->method('getUri')->willReturn($uri);
    
        return $mock;
    }
    
    public function testClassExists()
    {
        $route = new Route('', '');
        $this->assertInstanceOf('\MW\Route', $route);
    }
    
    public function testNotMatchingRoute()
    {
        $route = new Route('', '');
        $this->assertFalse($route->match($this->getRequestMock('articles')));
    }

    public function testMatchingEmptyRoute()
    {
        $route = new Route('', '');
        $this->assertTrue($route->match($this->getRequestMock()));
    }

    public function testNotMatchingRoute1()
    {
        $route = new Route('notmatching', '');
        $this->assertFalse($route->match($this->getRequestMock('articles')));
    }

    public function testMatchingRoute()
    {
        $route = new Route('articles', '');
        $this->assertTrue($route->match($this->getRequestMock('articles')));
    }
    
    public function testEmptyController()
    {
        $route = new Route('articles', '');
        $this->assertEquals('', $route->getControllerClass());
    }

    public function testNotEmptyController()
    {
        $route = new Route('articles', 'not_empty');
        $this->assertEquals('not_empty', $route->getControllerClass());
    }
}