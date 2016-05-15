<?php namespace MW\Models;

use MW\Model;

/**
 * Class Migration
 * @package MW\Models
 */
class Migration extends Model
{
    /**
     * @var string
     */
    protected $tableName = 'migrations';

    /**
     * @var string
     */
    protected $primaryKey = 'migration';
}
