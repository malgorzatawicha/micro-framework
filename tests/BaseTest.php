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
            ->setMethods(['getUri', 'isGet', 'isPost'])
            ->getMock();
        return $mock;
    }

    protected function getOutputMock()
    {
        return $this->getMockBuilder('\MW\Output')
            ->setMethods(['header', 'content'])
            ->getMock();
    }
    
    protected function getStmtMockForFetchAll($result)
    {
        $mock = $this->getMock('PDOStatement');
        $mock->expects($this->any())
            ->method('fetchAll')
            ->will($this->returnValue($result));
        return $mock;
    }
    
    protected function getPDOMockForFetchAll($result)
    {
        $mock = $this->getMock('mockPDO');
        $mock->expects($this->any())
            ->method('prepare')
            ->will($this->returnValue($this->getStmtMockForFetchAll($result)));
        
    }
    
    protected function getPDOMock()
    {
        return $this->getMockBuilder('\Tests\MockPDO')->getMock();
    }
    protected function getConnectionMock()
    {
        return $this->getMockBuilder('\MW\Connection')
            ->setConstructorArgs(['pdo' => $this->getPDOMock()])
            ->getMock();
    }
}
