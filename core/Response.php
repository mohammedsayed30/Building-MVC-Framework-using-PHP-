<?php
 
 namespace app\core;

 /**
 * Handles HTTP responses, including setting status codes and redirecting users.
 *
 * This class provides functionality to manipulate HTTP responses, such as
 * setting status codes and redirecting users to specific URLs.
 *
 * @package app\core
 */

class Response{

    /**
     * Sets the HTTP response status code.
     *
     * @param int $code The HTTP status code to set (e.g., 200, 404, 500).
     */

    public  function setStatusCode(int $code){
        //just to change the response status code depending on the request
        http_response_code($code);
    }

    /**
     * Redirects the user to a specified URL.
     *
     * This method sends a `Location` header to the client, instructing the browser
     * to navigate to the specified URL.
     *
     * @param string $url The URL to redirect to.
     */
    public function redirect(string $url)
    {
        // $scheme =!empty($_SERVER['HTTPS'])  &&  $_SERVER['HTTPS'] !=='off' ? 'https' : 'http' ;
        // $host =$_SERVER['HTTP_HOST'];
        // $full_url = $scheme . '://' . $host . $path;
        header('Location: ' . $url);
    }
}
