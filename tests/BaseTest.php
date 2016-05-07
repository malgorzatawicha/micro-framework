<?php namespace Tests;


abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    protected function getRequestValueMock()
    {
        return $this->getMockBuilder('\MW\RequestValue')
            ->setMethods(['get', 'post', 'requestUri'])
            ->getMock();
    }
    
    protected function getRequestMock()
    {
        $mock = $this->getMockBuilder('\MW\Request')
            ->setConstructorArgs(['requestValue' => $this->getRequestValueMock()])
            ->setMethods(['getUri'])
            ->getMock();
        return $mock;
    }
}