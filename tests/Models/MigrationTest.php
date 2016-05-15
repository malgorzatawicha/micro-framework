<?php namespace Tests\Models;

use MW\Models\Migration;
use MW\SQLBuilderFactory;
use Tests\BaseTest;

class MigrationTest extends BaseTest
{
    public function testClassExists()
    {
        $class = new Migration($this->getSqlBuilderFactoryMock());
        $this->assertInstanceOf('\MW\Models\Migration', $class );
    }

    public function testFind()
    {
        $sqlBuilder = $this->getSelectQueryMock('migrations', ['migration' => 1]);
        $sqlBuilder->expects($this->once())->method('first')->willReturn(['migration' => '1']);
        $sqlBuilderFactory = $this->getSqlBuilderFactoryMock();
        $sqlBuilderFactory->expects($this->once())->method('getSelectQuery')
            ->will($this->returnValue($sqlBuilder));
        
        $model = new Migration($sqlBuilderFactory);
        $result = $model->find(1);
        $this->assertEquals(['migration' => 1], $result);
    }

    public function testGet()
    {
        $sqlBuilder = $this->getSelectQueryMock('migrations');
        $sqlBuilder->expects($this->once())->method('all')->willReturn([['migration' => '1']]);
        $sqlBuilderFactory = $this->getSqlBuilderFactoryMock();
        $sqlBuilderFactory->expects($this->once())->method('newSqlBuilderInstance')->with(SQLBuilderFactory::SELECT)
            ->will($this->returnValue($sqlBuilder));

        $model = new Migration($sqlBuilderFactory);
        $result = $model->get();
        $this->assertEquals([['migration' => 1]], $result);
    }

    public function testInsert()
    {
        $sqlBuilder = $this->getInsertQueryMock('migrations', ['migration' => '1'], '1');
        $sqlBuilderFactory = $this->getSqlBuilderFactoryMock();
        $sqlBuilderFactory->expects($this->once())->method('newSqlBuilderInstance')->with(SQLBuilderFactory::INSERT)
            ->will($this->returnValue($sqlBuilder));

        $model = new Migration($sqlBuilderFactory);
        $result = $model->insert(['migration' => 1]);
        $this->assertEquals('1', $result);
    }

    public function testDelete()
    {
        $sqlBuilder = $this->getDeleteQueryMock('migrations', ['migration' => '1'], 1);
        $sqlBuilderFactory = $this->getSqlBuilderFactoryMock();
        $sqlBuilderFactory->expects($this->once())->method('newSqlBuilderInstance')->with(SQLBuilderFactory::DELETE)
            ->will($this->returnValue($sqlBuilder));

        $model = new Migration($sqlBuilderFactory);
        $result = $model->delete(['migration' => 1]);
        $this->assertEquals(1, $result);
    }

    public function testCustomQuery()
    {
        $sqlBuilder = $this->getCustomQueryMock('dummy', true);

        $sqlBuilderFactory = $this->getSqlBuilderFactoryMock();
        $sqlBuilderFactory->expects($this->once())->method('newSqlBuilderInstance')->with(SQLBuilderFactory::CUSTOM)
            ->will($this->returnValue($sqlBuilder));

        $model = new Migration($sqlBuilderFactory);
        $result = $model->executeCustomQuery('dummy');
        $this->assertTrue($result);
    }
}
