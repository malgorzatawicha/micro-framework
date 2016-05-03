<?php namespace Tests\SQLBuilder;

use MW\Connection;
use MW\SQLBuilder\Update;

class UpdateTest extends \PHPUnit_Framework_TestCase
{
    private function classBuilder()
    {
        return new Update(new Connection());
    }
    
    public function testClassExists()
    {
        $this->assertInstanceOf('\MW\SQLBuilder\Update', $this->classBuilder());    
    }

    public function testSql()
    {
        $query = $this->classBuilder();
        $this->assertEquals('', $query->sql());
    }
}