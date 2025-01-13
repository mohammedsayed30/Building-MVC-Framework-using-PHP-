<?php

namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\core\Application;
use app\models\contactForm;


/**
 * Class siteController
 * Handles site-related requests and rendering views for the application.
 *
 * @package app\controllers
 */
class siteController extends Controller
{
   
    /**
     * Renders the home page with dynamic data.
     *
     * @return string The rendered home page view.
     */
    public function home(): string
    {
        $params = [
            'name' => 'klay' // Example dynamic data
        ];
        return $this->render('home', $params);
    }

    /**
     * Handles the contact form submission.
     *
     * @param Request $request The HTTP request object containing form data.
     * @return void
     */
    public function contact(Request $request)
    {
        $contactForm = new contactForm();
        if($request->isPost()){
            //get the  conact body
            $contactBody = $request->getBody();
            //load the data of the conact message
            $contactForm -> loadData($contactBody);
            //validate the input conact
            if($contactForm->validate()){
                //set the message to display the user 
                $message = "We've got your information ,Thanks a lot";
                //set the flash message session for only one request
                Application::$app->session->setFlash('success',$message);
                //redirect the user to the home page
                Application::$app->response->redirect('/');
              
            }
            //render the contact view
            return $this->render('contact',[
                'model'=>$contactForm
            ]);
        }else{
            return $this->render('contact',[
                'model'=>$contactForm
            ]);
        }


    }
}
