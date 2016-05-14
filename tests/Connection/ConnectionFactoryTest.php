<?php namespace Tests\Connection;

use MW\Connection\ConnectionFactory;
use MW\Connection\PDOFactory;
use Tests\BaseTest;

class ConnectionFactoryTest extends BaseTest
{
    public function testClassExists()
    {
        $factory = new ConnectionFactory(new PDOFactory());
        $this->assertInstanceOf('\MW\Connection\ConnectionFactory', $factory);
    }

    /**
     * @expectedException \MW\Connection\ConnectionConfigurationException
     */
    public function testConnectionWhenDefaultConnectionNotFound()
    {
        $factory = new ConnectionFactory(new PDOFactory(), ['foo' => []]);
        $factory->getConnection();
    }

    /**
     * @expectedException  \MW\Connection\ConnectionConfigurationException
     */
    public function testDefaultConnectionWithEmptyDriver()
    {
        $factory = new ConnectionFactory(new PDOFactory(), ['default' => []]);
        $factory->getConnection();
    }

    /**
     * @expectedException  \MW\Connection\ConnectionConfigurationException
     */
    public function testDefaultConnectionWithNonExistentDriver()
    {
        $factory = new ConnectionFactory(new PDOFactory(), ['default' => [
            'driver' => 'doesnotexists'
        ]]);
        $factory->getConnection();
    }
    
    public function testConnectionWithMysqlDriver()
    {
        $factory = new ConnectionFactory(new PDOFactory('\Tests\MockPDO'), ['default' => [
            'driver' => 'mysql'
        ]]);
        $connection = $factory->getConnection();
        $this->assertInstanceOf('\MW\Connection\MysqlConnection', $connection);
    }
}
