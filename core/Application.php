<?php

namespace app\core;

use app\models\userLogin;


/**
 * The core Application class.
 *
 * This class serves as the central point of the application, managing routing,
 * requests, responses, sessions, and database connections.
 *
 * @package app\core
 */

class  Application{
   public Router $router;
   public Request $request;
   public Response $response;
   public Session $session;
   public Database $db;
   public Controller $controller;
   public static Application $app;
   public static string $ROOT_DIR;
    public function __construct($path,array $config)
    {
        self::$ROOT_DIR  = $path;
        //make the current object accessable anywhere inside the script
        self::$app=$this;   
        //create an instance from these classes
        $this->request=new Request();
        $this->session=new Session();
        $this->controller=new Controller();
        $this->response=new Response();
        $this->db=new Database($config['db']);
        $this->router=new Router( $this->request,$this->response);
    }
    //this to run the application to display the suitable HTML for every req
    public function run()
    {
        try{
            //if everything good display the required page 
            echo $this->router->resolve();
        }
        /*
        * $e object variable from \Exception can hold any throw execption
        * either ForbiddenException or NotFoundException the throw in 
        * Router Class
        */
        catch(\Exception $e){
            //display error if ther is any exception (Forbidden/notFound)
            $this->response->setStatusCode($e->getCode());
            //display the error message in _error page
            echo $this->router->renderView('_error',[
                'exception' => $e
            ]);
        }
    }

}