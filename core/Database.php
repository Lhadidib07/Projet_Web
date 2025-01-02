<?php


class Database
{
    const DSN = 'mysql:host=localhost;dbname=';
    const DB_NAME = 'web_rouen';
    const DB_USER = 'root';
    const DB_PASS = '';

    // CONCATENATION DE LA CONSTANTE DSN AVEC LA CONSTANTE DB_NAME
    const DSN_DB = self::DSN . self::DB_NAME;

    public PDO $pdo;


    public function __construct()
    {
        $this->pdo = new PDO(self::DSN_DB, self::DB_USER, self::DB_PASS);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public function applyMigrations()
    {
        $this->createMigrationTable();
        $appliedMirgrations = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR . '/migrations');

        $toApplyMigrations = array_diff($files, $appliedMirgrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }
            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            echo "Applying migration $migration" . PHP_EOL;
            $instance->up();
            echo "Applied migration $migration" . PHP_EOL;
            $newMigrations[] = $migration;
        }
        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            echo "All migrations are applied";
        }

    }

    public function createMigrationTable(){
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ) ENGINE=INNODB;");
    }

    public function getAppliedMigrations(){
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $migrations = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $migrations");
        $statement->execute();
    }

    public function prepare($sql)
    {
        $statement = $this->pdo->prepare($sql);
        return $statement;
    }



}