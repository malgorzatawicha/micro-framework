<?php namespace Tests;


use MW\SQLBuilder\Criteria\Equals;

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
    
    protected function getSqlBuilderFactoryMock()
    {
        return $this->getMockBuilder('\MW\SQLBuilderFactory')
            ->setConstructorArgs(['connection' => $this->getConnectionMock()])
            ->getMock();
    }

    protected function getCustomQueryMock($query, $result = true)
    {
        $mock = $this->getMockBuilder('\MW\SQLBuilder\CustomQuery')
            ->setConstructorArgs(['connection' => $this->getConnectionMock()])
            ->getMock();
        
        $mock->expects($this->once())->method('query')->with($query)->will($this->returnValue($mock));
        $mock->expects($this->once())->method('execute')->willReturn($result);
        return $mock;
    }
    protected function getSelectQueryMock($table, $criteria = [])
    {
        $mock = $this->getMockBuilder('\MW\SQLBuilder\SelectQuery')
            ->setConstructorArgs(['connection' => $this->getConnectionMock()])
            ->getMock();

        $mock->expects($this->once())->method('table')->with($table)->will($this->returnValue($mock));
        foreach ($criteria as $key => $value) {
            $mock->expects($this->once())->method('where')->with(new Equals($key, $value))->will($this->returnValue($mock));
        }
        return $mock;
    }

    protected function getDeleteQueryMock($table, $criteria = [], $return = 0)
    {
        $mock = $this->getMockBuilder('\MW\SQLBuilder\DeleteQuery')
            ->setConstructorArgs(['connection' => $this->getConnectionMock()])
            ->getMock();

        $mock->expects($this->once())->method('table')->with($table)->will($this->returnValue($mock));
        foreach ($criteria as $key => $value) {
            $mock->expects($this->once())->method('where')->with(new Equals($key, $value))->will($this->returnValue($mock));
        }
        
        $mock->expects($this->once())->method('execute')->willReturn($return);
        return $mock;
    }
    
    protected function getInsertQueryMock($table, $data, $return)
    {
        $mock = $this->getMockBuilder('\MW\SQLBuilder\InsertQuery')
            ->setConstructorArgs(['connection' => $this->getConnectionMock()])
            ->getMock();

        $mock->expects($this->once())->method('table')->with($table)->will($this->returnValue($mock));
        $mock->expects($this->once())->method('data')->with($data)->will($this->returnValue($mock));

        $mock->expects($this->once())->method('insert')->willReturn($return);
        return $mock;
    }
    
    protected function getMigrationModelMock()
    {
        return $this->getMockBuilder('\MW\Models\Migration')
            ->setConstructorArgs(['sqlBuilderFactory' => $this->getSqlBuilderFactoryMock()])
            ->getMock();
    }

    protected function getDirectoryIteratorFactoryMock()
    {
        return $this->getMockBuilder('\MW\DirectoryIteratorFactory')
            ->getMock();
    }
}
