<?php namespace Tests;

use MW\Connection;

class ConnectionTest extends BaseTest
{
    public function testClassExists()
    {
        $class = new Connection($this->getPDOMock());
        $this->assertInstanceOf('\MW\Connection', $class);
    }

    private function getPdoStmtMock($parameters, $executeResult)
    {
        $mock = $this->getMock('PDOStatement');
        $mock->expects($this->once())
            ->method('execute')
            ->with($parameters)
            ->willReturn($executeResult);
        return $mock;
    }
    
    private function getPdoStmtForFetchMock($parameters, $executeResult)
    {
        $mock = $this->getMock('PDOStatement');
        $mock->expects($this->once())
            ->method('execute')
            ->with($parameters)
            ->willReturn($executeResult);

        $mock->expects($this->once())
            ->method('setFetchMode')
            ->with(\PDO::FETCH_ASSOC);
        return $mock;
    }
    private function getPdoStmtMockForFetch($parameters, $executeResult, $result)
    {
        $mock = $this->getPdoStmtForFetchMock($parameters, $executeResult);
        
        $mock->expects($this->once())
            ->method('fetch')
            ->willReturn($result);
        return $mock;
    }

    private function getPdoStmtMockForFetchAll($parameters, $executeResult, $result)
    {
        $mock = $this->getPdoStmtForFetchMock($parameters, $executeResult);

        $mock->expects($this->once())
            ->method('fetchAll')
            ->willReturn($result);
        return $mock;
    }

    private function getPdoMockWithStmt($parameters, $stmt)
    {
        $mock = $this->getMock('\Tests\MockPDO');
        $mock->expects($this->once())
            ->method('prepare')
            ->with($parameters)
            ->willReturn($stmt);
        return $mock;
    }
    public function testFetching()
    {
        $sql = 'some sql';
        $parameters = ['some parameters'];

        $stmt = $this->getPdoStmtMockForFetch($parameters, true, ['foo' => 'bar']);
        
        $pdo = $this->getPdoMockWithStmt($sql, $stmt);
        
        $connection = new Connection($pdo);
        
        $result = $connection->fetch($sql, $parameters);
        $this->assertEquals(['foo' => 'bar'], $result);
    }

    public function testFetchingAll()
    {
        $sql = 'some sql';
        $parameters = ['some parameters'];

        $stmt = $this->getPdoStmtMockForFetchAll($parameters, true, [['foo' => 'bar'], ['foo1' => 'bar1']]);

        $pdo = $this->getPdoMockWithStmt($sql, $stmt);

        $connection = new Connection($pdo);

        $result = $connection->fetchAll($sql, $parameters);
        $this->assertEquals([['foo' => 'bar'], ['foo1' => 'bar1']], $result);
    }
    
    public function testInserting()
    {
        $sql = 'some sql';
        $parameters = ['some parameters'];

        $stmt = $this->getPdoStmtMock($parameters, true);

        $pdo = $this->getPdoMockWithStmt($sql, $stmt);

        $pdo->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(1);
        
        $connection = new Connection($pdo);

        $result = $connection->insert($sql, $parameters);

        $this->assertEquals(1, $result);
    }

    public function testExecuting()
    {
        $sql = 'some sql';
        $parameters = ['some parameters'];

        $stmt = $this->getPdoStmtMock($parameters, true);
        $stmt->expects($this->once())
            ->method('rowCount')
            ->willReturn(1);
        
        $pdo = $this->getPdoMockWithStmt($sql, $stmt);
        
        $connection = new Connection($pdo);

        $result = $connection->execute($sql, $parameters);

        $this->assertEquals(1, $result);
    }

    /**
     * @expectedException \Exception
     */
    public function testTransactionFailed()
    {
        $pdo = $this->getPDOMock();
        $pdo->expects($this->once())
            ->method('beginTransaction');

        $pdo->expects($this->once())
            ->method('rollBack');
        
        $connection = new Connection($pdo);
        
        $connection->transaction(function(){
            throw new \Exception('dummy');
        });
        
    }

    public function testTransactionOk()
    {
        $pdo = $this->getPDOMock();
        $pdo->expects($this->once())
            ->method('beginTransaction');

        $pdo->expects($this->once())
            ->method('commit');

        $connection = new Connection($pdo);

        $connection->transaction(function(){
            
        });

    }

    /**
     * @expectedException \MW\Connection\ConnectionException 
     */
    public function testFailedExecuting()
    {
        $sql = 'some sql';
        $parameters = ['some parameters'];

        $stmt = $this->getPdoStmtMock($parameters, false);

        $pdo = $this->getPdoMockWithStmt($sql, $stmt);

        $connection = new Connection($pdo);

        $connection->execute($sql, $parameters);
    }
}
