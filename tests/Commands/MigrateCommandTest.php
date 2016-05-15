<?php namespace Tests\Commands;

use MW\Commands\MigrateCommand;
use MW\Models\Migration;
use MW\SQLBuilderFactory;
use Tests\BaseTest;

class MigrateCommandTest extends BaseTest
{
    public function testClassExists()
    {
        $class = new MigrateCommand($this->getMigrationModelMock(), []);
        $this->assertInstanceOf('\MW\Commands\MigrateCommand', $class);
    }

    public function testExecuting()
    {
        // @TODO how to test callable?        
    }
}
