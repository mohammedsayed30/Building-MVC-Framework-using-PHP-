<?php

use app\core\Application;
/**
 *  just add column table 
 */
class m0002_add_password_column{
   //add the column
    public function up(){
        $db =\app\core\Application::$app->db;
        $SQL = "ALTER TABLE Users ADD COLUMN password VARCHAR(512) NOT NULL;";
        $db->pdo->exec($SQL);
    }
  //delete the column 
    public function down(){
        $db =\app\core\Application::$app->db;
        $SQL = "ALTER TABLE Users DROP COLUMN password;";
        $db->pdo->exec($SQL);
    }
}