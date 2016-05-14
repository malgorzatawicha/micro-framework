<?php namespace MW\Connection;

class PDOFactory
{
    private $pdoClassName;
    private $defaultConfig = [
        'driver' => '',
        'host' => '',
        'name' => '',
        'user' => '',
        'password' => ''
    ];
    public function __construct($pdoClassName = '\PDO')
    {
        $this->pdoClassName = $pdoClassName;
    }

    public function getPDO(array $config)
    {
        $config = array_merge($this->defaultConfig, $config);
        return new $this->pdoClassName(
            "{$config['driver']}:host=".$config['host'].";dbname=".$config['name'],
            $config['user'], $config['password']);
    }
}
