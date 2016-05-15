<?php namespace MW\Commands;

use MW\DependencyInjectionContainer;

/**
 * Class CommandDispatcher
 * @package MW\Commands
 */
class CommandDispatcher
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * @var DependencyInjectionContainer
     */
    private $dependencyInjectionContainer;

    /**
     * @var array
     */
    private $commands = [];

    /**
     * CommandDispatcher constructor.
     * @param DependencyInjectionContainer $dependencyInjectionContainer
     * @param array $commands
     * @param array $arguments
     */
    public function __construct(
        DependencyInjectionContainer $dependencyInjectionContainer, 
        array $commands,
        array $arguments = [])
    {
        $this->dependencyInjectionContainer = $dependencyInjectionContainer;
        $this->commands = $commands;
        $this->arguments = $arguments;
    }

    /**
     * @return bool
     * @throws CommandNotFoundException
     */
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

    /**
     * @param $commandName
     * @return bool
     * @throws CommandNotFoundException
     */
    private function dispatchCommand($commandName)
    {
        foreach ($this->commands as $className) {
            if (!$this->classNameMatchesCommand($className, $commandName)) {
                continue;
            }
            $command = null;
            if ($this->dependencyInjectionContainer->hasService($className)) {
                $command = $this->dependencyInjectionContainer->getNewService($className);
            } else if (class_exists($className)){
                $reflectionMethod = new \ReflectionMethod($className, '__construct');
                if (empty($reflectionMethod->getParameters())) {
                    $command = new $className();    
                } else {
                    throw new CommandNotFoundException();
                }
            }
            
            if ($command instanceof Command) {
                return $command->execute($this->arguments);
            }
        }
        
        throw new CommandNotFoundException();
    }

    /**
     * @param string $className
     * @param string $commandName
     * @return bool
     */
    private function classNameMatchesCommand($className, $commandName)
    {
        $classNameToMatch = implode('\\', explode(':', $commandName));
        return !empty(stristr($className, $classNameToMatch . 'Command'));
    }
}
