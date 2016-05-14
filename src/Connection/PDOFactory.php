<?php namespace MW\Connection;

class PDOFactory
{
    public function getPDO(array $config)
    {
        try {
            return new \PDO(
                "{$config['driver']}:host=".$config['host'].";dbname=".$config['name'],
                $config['user'], $config['password']);
        } catch (\PDOException $e) {
            throw new \PDOException("Error  : " .$e->getMessage());
        }
    }
}
