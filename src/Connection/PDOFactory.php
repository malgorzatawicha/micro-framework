<?php namespace MW\Connection;

/**
 * Class PDOFactory
 * @package MW\Connection
 */
class PDOFactory
{
    /**
     * @var string
     */
    private $pdoClassName;

    /**
     * @var array
     */
    private $defaultConfig = [
        'driver' => '',
        'host' => '',
        'name' => '',
        'user' => '',
        'password' => ''
    ];

    /**
     * PDOFactory constructor.
     * @param string $pdoClassName
     */
    public function __construct($pdoClassName = '\PDO')
    {
        $this->pdoClassName = $pdoClassName;
    }

    /**
     * @param array $config
     * @return \PDO
     */
    public function getPDO(array $config)
    {
        $config = array_merge($this->defaultConfig, $config);
        $dns = sprintf('%s:host=%s;dbname=%s', $config['driver'], $config['host'], $config['name']);
        return new $this->pdoClassName(
            $dns,
            $config['user'],
            $config['password']
        );
    }
}
