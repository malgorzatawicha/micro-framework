<?php namespace Tests\Commands;

use MW\Commands\CommandDispatcher;
use MW\Commands\CommandNotFoundException;
use MW\Commands\HelpCommand;
use MW\DependencyInjectionContainer;
use Tests\BaseTest;
use Tests\MockHelpCommand;

class CommandDispatcherTest extends BaseTest
{
    public function testClassExists()
    {
        $class = new CommandDispatcher(new DependencyInjectionContainer(), [], []);
        $this->assertInstanceOf('\MW\Commands\CommandDispatcher', $class);
    }

    /**
     * @expectedException \MW\Commands\CommandNotFoundException
     */
    public function testDispatchingEmpty()
    {
        $container = new DependencyInjectionContainer();

        $class = new CommandDispatcher($container, [], []);
        $class->dispatch();
    }
    
    public function testDispatchingHelpCommandThroughDependencyContainer()
    {
        $container = new DependencyInjectionContainer();
        $self = $this;
        $container->addService('helpCommand', function() use ($self) {
            return $self->getMockBuilder('\MW\Commands\HelpCommand')
                ->setConstructorArgs([
                    'directoryIteratorFactory' => $this->getDirectoryIteratorFactoryMock(),
                    'output' => $this->getOutputMock(),
                    'arguments' => []])
                ->getMock();
        });

        $class = new CommandDispatcher($container, ['helpCommand'], []);
        $class->dispatch();
    }

    /**
     * @expectedException \MW\Commands\CommandNotFoundException
     */
    public function testDispatchingHelpCommand()
    {
        $container = new DependencyInjectionContainer();

        $class = new CommandDispatcher($container, ['\MW\Commands\HelpCommand'], []);
        $class->dispatch();
    }

    public function testDispatchingMockHelpCommand()
    {
        $container = new DependencyInjectionContainer();

        $class = new CommandDispatcher($container, ['\Tests\MockHelpCommand'], []);
        $class->dispatch();
    }
    
    public function testDispatchingDummyCommand()
    {
        $container = new DependencyInjectionContainer();
        $self = $this;
        $container->addService('DummyCommand', function() use ($self) {
            return new MockHelpCommand();
        });

        $class = new CommandDispatcher($container, ['DummyCommand'], ['dummy']);
        $class->dispatch();
    }

    /** @expectedException \MW\Commands\CommandNotFoundException */
    public function testCommandNotFound()
    {
        $container = new DependencyInjectionContainer();
        $class = new CommandDispatcher($container, ['DummyCommand'], ['dummy']);
        $class->dispatch();
    }
}
