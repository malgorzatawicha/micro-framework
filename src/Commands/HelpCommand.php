<?php namespace MW\Commands;

use MW\DirectoryIteratorFactory;
use MW\Output;

/**
 * Class HelpCommand
 * @package MW\Commands
 */
class HelpCommand extends Command
{
    /**
     * @var DirectoryIteratorFactory
     */
    private $directoryIteratorFactory;

    /**
     * @var Output
     */
    private $output;

    /**
     * @var array
     */
    private $searchPaths;

    /**
     * HelpCommand constructor.
     * @param DirectoryIteratorFactory $factory
     * @param Output $output
     * @param array $searchPaths
     */
    public function __construct(
        DirectoryIteratorFactory $factory,
        Output $output,
        array $searchPaths
    )
    {
        $this->directoryIteratorFactory = $factory;
        $this->output                   = $output;
        $this->searchPaths              = $searchPaths;
    }

    /**
     * @param array $arguments
     * @return bool
     */
    public function execute(array $arguments = [])
    {        
        $commands = [];
        foreach ($this->searchPaths as $path) {
            $files    = $this->findAllFilesInDirectory($path);
            $commands = array_merge($commands, $this->makeCommands($path, $files));
        }

        $this->printCommands($commands);
        return true;
    }

    /**
     * @param string $directory
     * @return array
     */
    private function findAllFilesInDirectory($directory)
    {
        $result = [];
        $dir    = $this->directoryIteratorFactory->getPhpDirectoryIterator($directory);
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

    /**
     * @param string $path
     * @param array $files
     * @return array
     */
    private function makeCommands($path, array $files = [])
    {
        $result = [];
        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            $filePath    = $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
            $commandName = trim(trim(str_replace('Command.php', '', str_replace($path, '', $filePath)), '.'), DIRECTORY_SEPARATOR);
            $result[]    = strtolower(implode(':', explode(DIRECTORY_SEPARATOR, $commandName)));
        }
        return $result;
    }

    /**
     * @param array $commands
     */
    private function printCommands(array $commands = [])
    {
        foreach ($commands as $command) {
            $this->output->content($command . "\n");
        }
    }
}
