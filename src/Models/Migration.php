<?php namespace MW\Models;

use MW\Model;

class Migration extends Model
{
    protected $tableName = 'migrations';
    protected $primaryKey = 'migration';
}
