<?php namespace MW\Commands;

use MW\DependencyInjectionContainer;

class CommandDispatcher
{
    private $arguments;
    private $dependencyInjectionContainer;
    private $commands = [];
    public function __construct(
        DependencyInjectionContainer $dependencyInjectionContainer, 
        array $commands,
        array $arguments = [])
    {
        $this->dependencyInjectionContainer = $dependencyInjectionContainer;
        $this->commands = $commands;
        $this->arguments = $arguments;
    }

    public function dispatch()
    {
        $commandName = array_shift($this->arguments);

        if (empty($commandName)) {
            return $this->dispatchCommand('help');
        }
        try {
            return $this->dispatchCommand($commandName);
        } catch (CommandNotFoundException $e) {
            return $this->dispatchCommand('help');
        }
    }
    
    private function dispatchCommand($commandName)
    {
        foreach ($this->commands as $className) {

            $command = null;
            if ($this->dependencyInjectionContainer->hasService($className)) {
                $command = $this->dependencyInjectionContainer->getNewService($className);
            } else if (class_exists($className)){
                try {
                    $command = new $className();
                } catch (\Exception $e) {
                    throw new CommandNotFoundException();
                }
            }
            
            if ($command instanceof Command) {
                return $command->execute($this->arguments);
            }
        }
        
        throw new CommandNotFoundException();
    }
}
