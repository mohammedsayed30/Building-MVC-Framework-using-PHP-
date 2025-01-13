<?php

use app\core\Application;

/**
 * Initial migration for creating the `Users` table.
 *
 * This migration defines the schema for the `Users` table, including columns for
 * user ID, email, first name, status, and creation timestamp.
 *
 * @package app\migrations
 */
class m0001_initial
{
    /**
     * Executes the "up" migration to create the `Users` table.
     *
     * This method creates the `Users` table with the following columns:
     * - `id`: Primary key, auto-incrementing integer.
     * - `email`: User's email address (required, unique).
     * - `firstname`: User's first name (required).
     * - `status`: User's status (e.g., active/inactive).
     * - `created_at`: Timestamp of when the user was created.
     */
    public function up()
    {
        // Get the database instance
        $db = Application::$app->db;

        // SQL statement to create the `Users` table
        $SQL = "CREATE TABLE Users (
               id INT AUTO_INCREMENT PRIMARY KEY,
               email VARCHAR(255) NOT NULL,
               firstname VARCHAR(255) NOT NULL,
               status TINYINT NOT NULL,
               created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
               ) ENGINE = INNODB;";

        // Execute the SQL statement
        $db->pdo->exec($SQL);
    }

    /**
     * Executes the "down" migration to drop the `Users` table.
     *
     * This method reverses the `up()` migration by dropping the `Users` table.
     */
    public function down()
    {
        // Get the database instance
        $db = Application::$app->db;

        // SQL statement to drop the `Users` table
        $SQL = "DROP TABLE Users;";

        // Execute the SQL statement
        $db->pdo->exec($SQL);
    }
}