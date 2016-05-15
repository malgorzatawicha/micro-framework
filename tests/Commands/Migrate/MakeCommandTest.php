<?php namespace Tests\Commands\Migrate;

use MW\Commands\Migrate\MakeCommand;
use Tests\BaseTest;

class MakeCommandTest extends BaseTest
{
    public function testClassExists()
    {
        $class = new MakeCommand($this->getMigrationModelMock());
        $this->assertInstanceOf('\MW\Commands\Migrate\MakeCommand', $class); 
    }

    public function testExecuting()
    {
        $modelMock = $this->getMigrationModelMock();
        $modelMock->expects($this->once())->method('executeCustomQuery')
            ->with('CREATE TABLE migrations(migration int(11))')->willReturn(true);
        
        $class = new MakeCommand($modelMock);

        $class->execute();
    }
}
