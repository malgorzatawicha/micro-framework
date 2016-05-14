<?php namespace MW\Commands\Migrate;

use MW\Commands\Command;

class RollbackCommand extends Command
{
    public function execute()
    {
        $migrationsInDb = $this->getMigrationsInDb();
        $migrationsToLoad = require __DIR__ . '/../../../app/migrations.php';
        foreach (array_reverse($migrationsToLoad, true) as $migration => $data) {
            if (in_array($migration, $migrationsInDb)) {
                $this->connection->executeGetRowCount($data['down']);
                $this->connection->executeGetRowCount('DELETE FROM migrations where migration = ?', [$migration]);
                echo "ROLLBACK: {$data['down']}\n";
            }
        }
    }

    private function getMigrationsInDb()
    {
        $result = [];
        $migrations = $this->connection->fetchAll("SELECT * FROM migrations");
        foreach ($migrations as $migration) {
            $result[] = $migration['migration'];
        }
        return $result;
    }
}
