<?php namespace Tests;


use MW\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{

    public function testClassExists()
    {
        $route = new Route('', '');
        $this->assertInstanceOf('\MW\Route', $route);
    }
    
    public function testNotMatchingRoute()
    {
        $route = new Route('', '');
        $this->assertFalse($route->match('articles'));
    }

    public function testMatchingEmptyRoute()
    {
        $route = new Route('', '');
        $this->assertTrue($route->match(''));
    }

    public function testNotMatchingRoute1()
    {
        $route = new Route('notmatching', '');
        $this->assertFalse($route->match('articles'));
    }

    public function testMatchingRoute()
    {
        $route = new Route('articles', '');
        $this->assertTrue($route->match('articles'));
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