<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\Select;

class SelectTest extends \PHPUnit_Framework_TestCase
{
    private function classBuilder()
    {
        return new Select(new Connection());
    }
    
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilder\Select', $this->classBuilder());    
    }
}