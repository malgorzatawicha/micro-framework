<?php namespace MW\Commands;

use MW\DirectoryIteratorFactory;
use MW\Output;

class HelpCommand extends Command
{
    private $directoryIteratorFactory;
    private $output;
    private $searchPaths;
    
    public function __construct(
        DirectoryIteratorFactory $directoryIteratorFactory,
        Output $output,
        array $searchPaths
    )
    {
        $this->directoryIteratorFactory = $directoryIteratorFactory;
        $this->output = $output;
        $this->searchPaths = $searchPaths;
    }

    public function execute(array $arguments = [])
    {        
        $commands = [];
        foreach ($this->searchPaths as $path) {
            $files = $this->findAllFilesInDirectory($path);
            $commands = array_merge($commands, $this->makeCommands($path, $files));
        }

        $this->printCommands($commands);
    }
    
    private function findAllFilesInDirectory($directory)
    {
        $result = [];
        $dir = $this->directoryIteratorFactory->getPhpDirectoryIterator($directory);
        // output all matches
        if (!empty($dir)) {
            foreach ($dir as $d) {
                if (!empty(strpos($d->getFilename(), 'Command.php'))) {
                    $result[] = $d;
                }
            }
        }
        return $result;
    }

    private function makeCommands($path, array $files = [])
    {
        $result = [];
        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            $filePath = $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
            $commandName = trim(trim(str_replace('Command.php', '', str_replace($path, '', $filePath)), '.'), DIRECTORY_SEPARATOR);
            
            $result[] = strtolower(implode(':', explode(DIRECTORY_SEPARATOR, $commandName)));
        }
        return $result;
    }
    
    private function printCommands(array $commands = [])
    {
        foreach ($commands as $command) {
            $this->output->content($command . "\n");
        }
    }
}
