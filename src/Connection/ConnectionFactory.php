<?php namespace MW\Connection;

class ConnectionFactory
{
    private $configs = [];
    private $pdoFactory;
    public function __construct(PDOFactory $pdoFactory, array $configs = [])
    {
        $this->pdoFactory = $pdoFactory;
        $this->configs = $configs;
    }

    public function getConnection($name = 'default')
    {
        if (!array_key_exists($name, $this->configs)) {
            $name = 'default';
        }

        if (!array_key_exists($name, $this->configs)) {
            throw new ConnectionConfigurationException();
        }

        $config = $this->configs[$name];

        $className = '\MW\Connection\\' . ucfirst($config['driver']) . 'Connection';
        
        return new $className($this->pdoFactory->getPDO($config));
    }
}
