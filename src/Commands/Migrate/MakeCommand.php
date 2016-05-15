<?php namespace MW\Commands\Migrate;

use MW\Commands\Command;
use MW\Models\Migration;
use MW\SQLBuilder\CustomQuery;
use MW\SQLBuilderFactory;

/**
 * Class MakeCommand
 * @package MW\Commands\Migrate
 */
class MakeCommand extends Command
{
    /**
     * @var string
     */
    private $sql = 'CREATE TABLE migrations(migration int(11))';

    /**
     * @var Migration
     */
    private $migrationModel;

    /**
     * MakeCommand constructor.
     * @param Migration $migrationModel
     */
    public function __construct(Migration $migrationModel)
    {
        $this->migrationModel = $migrationModel;
    }

    /**
     * @param array $arguments
     * @return bool
     */
    public function execute(array $arguments = [])
    {
        return !empty($this->migrationModel->executeCustomQuery($this->sql));
    }
}
