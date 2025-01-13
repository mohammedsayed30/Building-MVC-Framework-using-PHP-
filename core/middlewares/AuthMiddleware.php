<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exception\ForbiddenException;

/**
 * Middleware for handling authentication and access control.
 *
 * This middleware restricts access to specific actions (routes) for guests (non-logged-in users).
 *
 * @package app\core\middlewares
 */

class AuthMiddleware extends BaseMiddleware
{
    /** @var array list to hold the files that user to be authenticate to access them**/ 
   public array $actions = [];

    /**
     * AuthMiddleware constructor.
     *
     * @param array $actions List of actions (routes) to restrict for guests.
     */
   public function __construct(array $actions)
   {
       //to hold all the restricted files in actions
       $this->actions = $actions;
   }

    /**
     * Executes the middleware logic.
     *
     * Checks if the user is a guest (not logged in) and if the current action is restricted.
     * If so, it throws a ForbiddenException.
     *
     * @throws ForbiddenException If the user is a guest and the action is restricted.
     */
    
   public function execute()
   {
        //if user is guest and Not Loged In
        if(! Application::$app->session->getSession('login')){
            /*this work for  if it is not empty empty and if action(user) exists in actions
            * Application::$app->controller->action -->that come from user
            *  and it has been set in The Route Class
            * ($this->actions)  -->that set by developers 
            */
            if(!empty($this->actions) && in_array(Application::$app->controller->action,$this->actions)){
                throw new ForbiddenException();
            }
        }
   }
    
} 