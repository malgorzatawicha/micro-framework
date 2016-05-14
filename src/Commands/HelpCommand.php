<?php namespace MW\Commands;

use MW\DirectoryIteratorFactory;

class HelpCommand extends Command
{
    public function __construct(DirectoryIteratorFactory $directoryIteratorFactory, array $arguments)
    {
        parent::__construct($arguments);
    }

    public function execute()
    {
        $searchPaths = [
            __DIR__,
            realpath(__DIR__ . '/../../app/Commands')
        ];
        
        $commands = [];
        foreach ($searchPaths as $path) {
            $files = $this->findAllFilesInDirectory($path);
            $commands = array_merge($commands, $this->makeCommands($path, $files));
        }

        $this->printCommands($commands);
    }
    
    private function findAllFilesInDirectory($directory)
    {
        $result = [];
        $dir = new \RecursiveIteratorIterator(
            new \RecursiveRegexIterator(
                new \RecursiveDirectoryIterator(
                    $directory,
                    \RecursiveDirectoryIterator::FOLLOW_SYMLINKS
                ),
                // match both php file extensions and directories
                '#(?<!/)\.php$|^[^\.]*$#i'
            ),
            true
        );
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
            $commandName = trim(str_replace('Command.php', '', str_replace($path, '', $filePath)), DIRECTORY_SEPARATOR);
            
            $result[] = strtolower(implode(':', explode(DIRECTORY_SEPARATOR, $commandName)));
        }
        return $result;
    }
    
    private function printCommands(array $commands = [])
    {
        foreach ($commands as $command) {
            echo $command . "\n";
        }
    }
}
