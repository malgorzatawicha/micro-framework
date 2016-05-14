<?php namespace MW\Commands;

class CommandDispatcher
{
    private $arguments;
    private $searchPaths = [
        '\App\Commands',
        '\MW\Commands'
    ];
    public function __construct(array $arguments = [])
    {
        $this->arguments = $arguments;
    }

    public function dispatch()
    {
        $commandName = array_shift($this->arguments);

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
                $command = new $className($this->arguments);
                if ($command instanceof Command) {
                    return $command->execute();
                }
            }
        }
        throw new CommandNotFoundException();
    }
}
