<?php namespace Tests\Commands;

use MW\Commands\HelpCommand;
use MW\DirectoryIteratorFactory;
use MW\Output;
use Tests\BaseTest;

class HelpCommandTest extends BaseTest
{

    public function testClassExists()
    {
        $class = new HelpCommand($this->getDirectoryIteratorFactoryMock(), $this->getOutputMock(), []);
        $this->assertInstanceOf('\MW\Commands\HelpCommand', $class);
    }

    public function testExecutingCommandWithEmptySearchPaths()
    {
        $class = new HelpCommand($this->getDirectoryIteratorFactoryMock(), $this->getOutputMock(), []);
        $class->execute([]);
    }

    public function testExecutingCommandWithDummySearchPaths()
    {
       
        $mock = $this->getDirectoryIteratorFactoryMock();
        $mock->expects($this->once())->method('getPhpDirectoryIterator')->with('dummy')->willReturn([new \SplFileInfo('test')]);
        $class = new HelpCommand($mock, $this->getOutputMock(), ['dummy']);
        $class->execute([]);
    }

    public function testExecutingCommandWithCommandInSearchPath()
    {

        $mock = $this->getDirectoryIteratorFactoryMock();
        $mock->expects($this->once())->method('getPhpDirectoryIterator')->with('dummy')->willReturn([new \SplFileInfo('TestCommand.php')]);
        $outputMock = $this->getOutputMock();
        $outputMock->expects($this->once())->method('content')->with("test\n");
        
        $class = new HelpCommand($mock, $outputMock, ['dummy']);
        $class->execute([]);
    }
}
