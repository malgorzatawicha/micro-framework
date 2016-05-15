<?php namespace Tests\Commands\Migrate;

use MW\Commands\Migrate\MakeCommand;
use MW\SQLBuilderFactory;
use Tests\BaseTest;

class MakeCommandTest extends BaseTest
{
    public function testClassExists()
    {
        $class = new MakeCommand($this->getSqlBuilderFactoryMock());
        $this->assertInstanceOf('\MW\Commands\Migrate\MakeCommand', $class); 
    }

    public function testExecuting()
    {
        $sqlBuilderFactoryMock = $this->getSqlBuilderFactoryMock();
        $sqlBuilderFactoryMock->expects($this->once())->method('newSqlBuilderInstance')
            ->with(SQLBuilderFactory::CUSTOM)->will($this->returnValue($this->getCustomQueryMock('CREATE TABLE migrations(migration int(11))')));
        
        $class = new MakeCommand($sqlBuilderFactoryMock);

        $class->execute();
    }
}
