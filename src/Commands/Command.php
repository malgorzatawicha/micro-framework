<?php namespace MW\Commands;

/**
 * Class Command
 * @package MW\Commands
 */
abstract class Command
{
    /**
     * @param array $arguments
     * @return bool
     */
    abstract public function execute(array $arguments = []);
}
