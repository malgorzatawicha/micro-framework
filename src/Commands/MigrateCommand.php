<?php namespace MW\Commands;

class MigrateCommand extends Command
{
    public function execute()
    {
        $migrationsInDb = $this->getMigrationsInDb();
        $migrationsToLoad = require __DIR__ . '/../../app/migrations.php';
        foreach ($migrationsToLoad as $migration => $data) {
            if (!in_array($migration, $migrationsInDb)) {
                $this->connection->executeGetRowCount($data['up']);
                $this->connection->executeGetLastInsertId('INSERT INTO migrations VALUES(?)', [$migration]);
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
