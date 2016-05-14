<?php namespace MW\Commands;


abstract class Command
{
    protected $arguments;
    
    public function __construct(array $arguments = [])
    {
        $this->arguments = $arguments;
    }

    abstract public function execute();
}
