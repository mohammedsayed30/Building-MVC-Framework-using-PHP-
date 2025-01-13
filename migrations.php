<?php



 //to use the application class that exist in the app\core\application
use app\core\Application;
//to use the siteController class that exist in the app\core\application
use app\controllers\siteController;
//to use the AuthController class that exist in the app\core\application
use app\controllers\AuthController;

use app\core\Database;

/*every thing in under namespace app will be inculded auto*/
require_once __DIR__.'/vendor/autoload.php';


//to load the configration from env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();



$config =[
  'db'=>[
  'dsn' => $_ENV['DB_DSN'],
  'user' => $_ENV['DB_USER'],
  'password' => $_ENV['DB_PASSWORD'],
  ]
];
/* Create an instance of Application Class to run the website */
$app = new  Application(__DIR__,$config);


$app->db->applyMigrations();




