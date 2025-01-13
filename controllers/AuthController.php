<?php

namespace app\controllers;

use app\core\middlewares\AuthMiddleware;
use app\core\Controller;
use app\core\Request;
use app\core\Application;
use app\models\User;
use app\models\userLogin;

/**
 * Class AuthController
 *
 * Controller for handling authentication-related actions such as 
 * login and register.
 */
class AuthController extends Controller
{
     /**
     * Class constructor.
     * this to define with files need to be authonticate to see them 
     */
    public function __construct()
    {
        //create the authmiddleware for profile file
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }
    /**
     * Handles the login functionality.
     *
     * @param Request $request The HTTP request object.
     * 
     * @return string The response after handling the login request.
     */

    public function login(Request $request)
    {
        //check if the already logined in or not 
        if(Application::$app->session->getSession('login')){
            //this mean the user aready logedin(redirect him to the home page )
            Application::$app->response->redirect('/');
        } 
        //create an object from userLogin class
        $login = new userLogin();
        //this mean the user senf the login form with the password and email
        if ($request->isPost()) {
            //get the data from the login post request
            $bodyData=$request->getBody();
            //load the data to the login object
            $login->loadData($bodyData);
            //validate the login information
            if($login->validate() ){
                //show succes registeration message and store them ito DB
               $message = "Loged In Successfully!" ;
               //set the success message for the user
               Application::$app->session->setFlash('success',$message);
               //create login session to make user logined until he logout
               Application::$app->session->setSession('login',"logedin");
               //redirect the user into the home page 
              Application::$app->response->redirect('/');
            }
            /**
             * this to render login page
             */
            return $this->render('login' ,[
                'model' => $login
            ]);
        }

        $this->setLayout('auth');
        return $this->render('login' ,[
            'model' => $login
        ]);
    }

    /**
     * Handles the register functionality.
     *
     * @param Request $request The HTTP request object.
     * 
     * @return string The response after handling the register request.
     */
    public function register(Request $request)
    {
        //create an object from User Class
        $User = new User();
        //if the request is post this mean the user send the register form
        if ($request->isPost()) {
            //this get the information that user enter to validate them
            $data = $request->getBody();
            //to load the data from user to the registeration model  
            $User->loadData($data);
              /*
             * after this here what will happen:-
             * $User->fristname = value of the user frist name  
             * $User->lastname = vlaue of the user last name 
             * $User->email = value of the user emial
             * $User->password = value of the user password
             * $User->repeatpassword = value of the confirmed user password
             */
           
             //validate the user input  
            if($User->validate() && $User->register()){
               //show succes registeration message and store them ito DB
               $message = "Registration successful! Welcome," .$User->fristname;
               //set the success message for the user
               Application::$app->session->setFlash('success',$message);
               //redirect the user into the home page 
              Application::$app->response->redirect('/');
            }
            /*this to display the register page */
            return $this->render('register' ,[
                'model' => $User
            ]);
        }
        //get request --> this mean the user want the register page 
        $this->setLayout('auth');
        return $this->render('register' ,[
            'model' => $User
        ]);
    }

    /**
     * unset the login session to make user logout from his profile .
     *
     * @return string The rendered contact page view.
     */

    public function logout(): string
    {
        //unset the login in session when the user logout from the website
        Application::$app->session->remove('login');
        //redirect the user into the home page 
        Application::$app->response->redirect('/');
    }

    /**
     * this  function to render the profile page
     * @param return the profile view if the user is authenticated
     */
    public function profile()
    {
        return $this->render('profile');    
    }
}
