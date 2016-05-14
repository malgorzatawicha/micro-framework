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

        if (empty($config['driver'])) {
            throw new ConnectionConfigurationException;
        }
        $className = '\MW\Connection\\' . ucfirst($config['driver']) . 'Connection';
        
        if (!class_exists($className)) {
            throw new ConnectionConfigurationException;
        }
        return new $className($this->pdoFactory->getPDO($config));
    }
}
