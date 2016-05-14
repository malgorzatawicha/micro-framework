<?php namespace Tests\Connection;

use MW\Connection\PDOFactory;
use Tests\BaseTest;

class PDOFactoryTest extends BaseTest
{
    public function testClassExists()
    {
        $factory = new PDOFactory();
        $this->assertInstanceOf('\MW\Connection\PDOFactory', $factory);
    }

    public function testGetPdo()
    {
        $factory = new PDOFactory('\Tests\MockPDO');
        $result = $factory->getPDO([]);
        $this->assertInstanceOf('\Tests\MockPDO', $result);
    }
}
