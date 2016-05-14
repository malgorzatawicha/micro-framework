<?php namespace MW\Commands;

use MW\SQLBuilderFactory;

abstract class Command
{
    protected $arguments;
    protected $sqlBuilderFactory;
    
    public function __construct(SQLBuilderFactory $SQLBuilderFactory, array $arguments = [])
    {
        $this->sqlBuilderFactory = $SQLBuilderFactory;
        $this->arguments = $arguments;
    }

    abstract public function execute();
}
