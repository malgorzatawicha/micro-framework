<?php namespace MW\Commands;

use MW\Connection;

class CommandDispatcher
{
    private $arguments;
    private $connection;
    private $searchPaths = [
        '\App\Commands',
        '\MW\Commands'
    ];
    public function __construct(Connection $connection, array $arguments = [])
    {
        $this->connection = $connection;
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
                $command = new $className($this->connection, $this->arguments);
                if ($command instanceof Command) {
                    return $command->execute();
                }
            }
        }
        throw new CommandNotFoundException();
    }
}
