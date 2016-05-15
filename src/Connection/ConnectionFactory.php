<?php namespace MW\Connection;
use MW\Connection;

/**
 * Class ConnectionFactory
 * @package MW\Connection
 */
class ConnectionFactory
{
    /**
     * @var array
     */
    private $configs = [];

    /**
     * @var PDOFactory
     */
    private $pdoFactory;

    /**
     * ConnectionFactory constructor.
     * @param PDOFactory $pdoFactory
     * @param array $configs
     */
    public function __construct(PDOFactory $pdoFactory, array $configs = [])
    {
        $this->pdoFactory = $pdoFactory;
        $this->configs    = $configs;
    }

    /**
     * @param string $name
     * @return Connection
     * @throws ConnectionConfigurationException
     */
    public function getConnection($name = 'default')
    {
        $config    = $this->getConfigByName($name);
        $className = $this->getClassNameByConfig($config);
        return new $className($this->pdoFactory->getPDO($config));
    }

    /**
     * @param string $name
     * @return mixed
     * @throws ConnectionConfigurationException
     */
    private function getConfigByName($name = 'default')
    {
        if (!array_key_exists($name, $this->configs)) {
            $name = 'default';
        }

        if (!array_key_exists($name, $this->configs)) {
            throw new ConnectionConfigurationException();
        }

        return $this->configs[$name];
    }

    /**
     * @param array $config
     * @return string
     * @throws ConnectionConfigurationException
     */
    private function getClassNameByConfig(array $config)
    {
        if (empty($config['driver'])) {
            throw new ConnectionConfigurationException;
        }
        $className = '\MW\Connection\\' . ucfirst($config['driver']) . 'Connection';

        if (!class_exists($className)) {
            throw new ConnectionConfigurationException;
        }
        return $className;
    }
}
