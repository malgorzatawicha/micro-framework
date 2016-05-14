<?php namespace MW;

class DirectoryIteratorFactory
{
    public function getPhpDirectoryIterator($directory)
    {
        return new \RecursiveIteratorIterator(
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
    }
}
