<?php namespace Tests;

use MW\Output;

class OutputTest extends BaseTest
{
    public function testClassExists()
    {
        $output = new Output();
        $this->assertInstanceOf('\MW\Output', $output);
    }
}
