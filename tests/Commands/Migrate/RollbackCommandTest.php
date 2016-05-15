<?php namespace Tests\Commands\Migrate;

use MW\Commands\Migrate\RollbackCommand;
use Tests\BaseTest;

class RollbackCommandTest extends BaseTest
{
    public function testClassExists()
    {
        $class = new RollbackCommand($this->getMigrationModelMock(), []);
        $this->assertInstanceOf('\MW\Commands\MigrateCommand', $class);
    }

    public function testExecuting()
    {
        // @TODO how to test callable?        
    }
}
