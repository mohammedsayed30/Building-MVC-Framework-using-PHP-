<?php

namespace app\core;

/**
 * This class is used to handle database connections and migrations.
 *
 * It provides functionality to apply migrations, create a migrations table,
 * and log migration-related messages.
 */
class Database
{
    /** @var \PDO The PDO instance for database interactions. */
    public \PDO $pdo;

    /**
     * Database constructor.
     *
     * Initializes the database connection using the provided configuration.
     *
     * @param array $config The database configuration array containing `dsn`, `user`, and `password`.
     */
    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        try {
            // Create a new PDO instance
            $this->pdo = new \PDO($dsn, $user, $password);
            // Set PDO to throw exceptions on errors
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            // Log error and exit if the connection fails
            echo "Database connection failed: " . $e->getMessage();
            exit;
        }
    }

    /**
     * Applies all pending migrations.
     *
     * Scans the migrations directory, applies unapplied migrations, and logs the process.
     */
    public function applyMigrations()
    {
        // Ensure the migrations table exists
        $this->createMigrationsTable();

        // Get the list of already applied migrations
        $appliedMigrations = $this->getAppliedMigrations();

        // Scan the migrations directory for migration files
        $files = scandir(Application::$ROOT_DIR . '/migrations');

        // Find migrations that haven't been applied yet
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        $newMigrations = [];
        foreach ($toApplyMigrations as $migration) {
            // Skip the current and parent directory references
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            // Include the migration file
            require_once Application::$ROOT_DIR . '/migrations/' . $migration;

            // Extract the class name from the file name
            $className = pathinfo($migration, PATHINFO_FILENAME);

            // Create an instance of the migration class
            $instance = new $className();

            // Log and apply the migration
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");

            // Add the migration to the list of new migrations
            $newMigrations[] = $migration;
        }

        // Save the newly applied migrations to the database
        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are applied");
        }
    }

    /**
     * Creates the migrations table if it doesn't already exist.
     */
    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
    }

    /**
     * Retrieves the list of already applied migrations.
     *
     * @return array An array of migration file names.
     */
    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Saves the list of applied migrations to the database.
     *
     * @param array $migrations An array of migration file names to save.
     */
    public function saveMigrations(array $migrations)
    {
        // Prepare the values for the SQL query
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));

        // Insert the migrations into the database
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
    }

    /**
     * Logs a message with a timestamp.
     *
     * @param string $message The message to log.
     */
    public function log($message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
    }
}