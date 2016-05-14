<?php namespace MW\Commands;


abstract class Command
{
    abstract public function execute(array $arguments = []);
}
