<?php
namespace app\core;
use app\core\exception\NotFoundException;

/**
 * Handles routing for the application.
 *
 * This class maps incoming HTTP requests to their corresponding callbacks or views,
 * and resolves them by executing the appropriate logic or rendering the appropriate view.
 *
 * @package app\core
 */

class  Router{

    /** @var array $routes Stores all registered routes for GET and POST methods. */
    private array $routes = [];

    /** @var Request The request instance for handling HTTP requests. */
    public Request $request;

    /** @var Response The response instance for handling HTTP responses. */
    public Response $response;

    /**
     * Router constructor.
     *
     * @param Request $request The request instance.
     * @param Response $response The response instance.
     */

    public function __construct(Request $request, Response $response)
    {
        $this->request=$request;
        $this->response=$response;
    }

     /**
     * Registers a GET route.
     *
     * @param string $path The route path (e.g., "/home").
     * @param callable|array|string $callback The callback to execute when the route is matched.
     */

    public function get($path,$callback)
    {
        //to assign ervery user input into a specific path or page to redirect the user
        $this->routes['get'][$path]=$callback;
    } 

        /**
     * Registers a POST route.
     *
     * @param string $path The route path (e.g., "/submit").
     * @param callable|array|string $callback The callback to execute when the route is matched.
     */

    public function post($path,$callback)
    {
        //to assign ervery user input into a specific path or page to redirect the user
        $this->routes['post'][$path]=$callback;
    }

     /**
     * Resolves the current request by matching it to a registered route.
     *
     * If a route is found, it executes the corresponding callback or renders the view.
     * If no route is found, it throws a NotFoundException.
     *
     * @return mixed The result of the callback or the rendered view.
     * @throws NotFoundException If no route matches the request.
     */
    public function resolve(){
        $path=$this->request->getpath();
        $method=$this->request->getmethod();
        $callback=$this->routes[$method][$path] ?? false;
        if($callback ===  false){
            //call the NotFoundException to display the error messages 
            throw new NotFoundException();
        }
        if(is_string($callback)){
            
            //if  it is a string this mean this file.php not a callback function
           return  $this->renderView($callback);
        }
        if(is_array($callback)){
             /*this to create an instance from the class that in $callback[0]
             * Note:- you can assign a child class (e.g., SiteController) to 
             * a property typed as the parent class (Controller) 
             */
            //create an object from the conrollers (Auth/site Controller)
            $controller= new $callback[0] ();
            //assign that object to the Controller object variable (controller)
            Application::$app->controller=$controller;
            /*to contain all restricted files like 'register'*/ 
            $controller->action = $callback[1];
            //this will make the class is an object from this class
            $callback[0]=$controller;
            //iterate for each middlewares (only one exists now AuthContoller)
            foreach($controller->getMiddlewares() as $middleware){
                //execute the middleware exception if uset not Auth
                $middleware->execute();
            }
         }
         /*
         * to  execute the fuction that is stored in the $callback 
         * if the request  is not forbidden and it is found
         */
        return call_user_func($callback,$this->request);
    }

    /**
     * Renders a view within a layout.
     *
     * @param string $view The view file to render (e.g., "home").
     * @param array $params An associative array of parameters to pass to the view.
     * @return string The rendered HTML content.
     */

    public function renderView($view,$params=[])
    {
        //for the navbar
        $layoutContent = $this->layoutContent();
        //this for the actual page i wanted to be viewed
        $viewContent = $this->renderOnlyView($view,$params);
        //replace {{content}} from $layoutContent  with $viewContent
        return  str_replace('{{content}}',$viewContent,$layoutContent );
    }  

   /**
     * Renders the layout content.
     *
     * @return string The rendered layout content.
     */

    protected function layoutContent()
    {
        /**
         * ob_start() --> It is a function that tells PHP to temporarily store all output (such as echo statements or plain HTML)
         *  in a buffer instead of immediately sending it to the browser.
         * ob_get_clean()--> is part of the output buffering mechanism. 
         * It retrieves the current contents of the output buffer and clears it.
         */

        $layout =  Application::$app->controller->layout;

        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    /**
     * Renders only the view content (without the layout).
     *
     * @param string $view The view file to render (e.g., "home").
     * */
    protected function renderOnlyView($view,$params=[])
    {
        foreach ($params as $key => $value){
            //to make the value of the key variable name and assign the value to this key
            $$key = $value;
        }
        /**
         * $$key is accessible inside $view.php file as we include the $view.php
         * in this function so the $view.php can access $$key 
         */
       ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";   
        return ob_get_clean();
    }


}