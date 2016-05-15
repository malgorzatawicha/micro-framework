<?php namespace MW\Connection;

use MW\Connection;

/**
 * Class MysqlConnection
 * @package MW\Connection
 */
class MysqlConnection extends Connection
{
    /**
     * @param string $name
     * @return string
     */
    public function escapeName($name)
    {
        return '`' . $name . '`';
    }

}
