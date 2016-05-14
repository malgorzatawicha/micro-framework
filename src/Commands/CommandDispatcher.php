<?php namespace MW\Commands;

use MW\SQLBuilderFactory;

class CommandDispatcher
{
    private $arguments;
    private $sqlBuilderFactory;
    private $searchPaths = [
        '\App\Commands',
        '\MW\Commands'
    ];
    public function __construct(SQLBuilderFactory $SQLBuilderFactory, array $arguments = [])
    {
        $this->sqlBuilderFactory = $SQLBuilderFactory;
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
    
    private function buildClassName($basePath, $commandName)
    {

        $className = $basePath;
        foreach (explode(':', $commandName) as $commandPart) {
            $className .= '\\' . ucfirst($commandPart);
        }
        $className .= 'Command';
        return $className;
    }

    private function dispatchCommand($commandName)
    {
        foreach ($this->searchPaths as $path) {
            $className = $this->buildClassName($path, $commandName);
            if (class_exists($className)) {
                $command = new $className($this->sqlBuilderFactory, $this->arguments);
                if ($command instanceof Command) {
                    return $command->execute();
                }
            }
        }
        throw new CommandNotFoundException();
    }
}
