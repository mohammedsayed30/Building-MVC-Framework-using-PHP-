<?php

use app\core\Application;
/**
 *  just add column table 
 */
class m0003_add_lastname{
   //add the column
    public function up(){
        $db =\app\core\Application::$app->db;
        $SQL = "ALTER TABLE Users ADD COLUMN lastname VARCHAR(512) NOT NULL;";
        $db->pdo->exec($SQL);
    }
  //delete the column 
    public function down(){
        $db =\app\core\Application::$app->db;
        $SQL = "ALTER TABLE Users DROP COLUMN lastname;";
        $db->pdo->exec($SQL);
    }
}