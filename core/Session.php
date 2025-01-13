<?php

/**
 *                      ##Session Mangement by PHP Explantion##
 * Only When the script ends, PHP saves the modified session data 
 * (which no longer includes $_SESSION['success']). this mean if you 
 * wanna delete the session messsage you have to do it after 
 * the script ends and PHP saves the modified session data -->this 
 * only can be done in __destruct() 
 * so the php saves the changes into $_SESSION before the __destruct()
 * method call
 */


namespace app\core;
/**
 * make session for one request 
 */

 

 /**
  * Handles session management, including flash messages and user login sessions.
  *
  * Flash messages are session messages that are displayed only once and then removed.
  * This class also manages user login sessions and provides methods to set, get, and remove session data.
  *
  * @package app\core
  */
 class Session
 {
     /** @var string The key used to store flash messages in the session. */
     protected const FLASH_MESSAGE_KEY = 'flash_messages';
 
     /** @var string The key used to store user login information in the session. */
     protected const LOGED_IN = 'user_login';
 
     /**
      * Session constructor.
      *
      * Starts the session and initializes flash messages for removal.
      */
     public function __construct()
     {
         // Start the session
         session_start();
 
         // Get all flash messages from the session
         $flashMessages = $_SESSION[self::FLASH_MESSAGE_KEY] ?? [];
 
         // Mark all flash messages for removal
         foreach ($flashMessages as $key => &$flashMessage) {
             $flashMessage['remove'] = true;
         }
 
         // Save the updated flash messages back to the session
         $_SESSION[self::FLASH_MESSAGE_KEY] = $flashMessages;
     }
 
     /**
      * Sets a flash message in the session.
      *
      * Flash messages are displayed only once and then removed.
      *
      * @param string $key The key for the flash message.
      * @param string $message The flash message to display.
      */
     public function setFlash($key, $message)
     {
         $_SESSION[self::FLASH_MESSAGE_KEY][$key] = [
             'remove' => false, // Mark the message to persist for one request
             'value' => $message,
         ];
     }
 
     /**
      * Sets a session value for a given key.
      *
      * This is typically used to store user login information.
      *
      * @param string $key The key for the session value.
      * @param mixed $value The value to store in the session.
      */
     public function setSession($key, $value)
     {
         $_SESSION[self::LOGED_IN][$key] = $value;
     }
 
     /**
      * Retrieves a session value for a given key.
      *
      * @param string $key The key for the session value.
      * @return mixed The session value, or `false` if the key does not exist.
      */
     public function getSession($key)
     {
         return $_SESSION[self::LOGED_IN][$key] ?? false;
     }
 
     /**
      * Removes a session value for a given key.
      *
      * @param string $key The key for the session value to remove.
      */
     public function remove($key)
     {
         unset($_SESSION[self::LOGED_IN][$key]);
     }
 
     /**
      * Retrieves a flash message for a given key.
      *
      * @param string $key The key for the flash message.
      * @return mixed The flash message, or `false` if the key does not exist.
      */
     public function getFlash($key)
     {
         return $_SESSION[self::FLASH_MESSAGE_KEY][$key]['value'] ?? false;
     }
 
     /**
      * Session destructor.
      *
      * Removes flash messages marked for deletion and updates the session.
      */
     public function __destruct()
     {
         // Get all flash messages from the session
         $flashMessages = $_SESSION[self::FLASH_MESSAGE_KEY] ?? [];
 
         // Remove flash messages marked for deletion
         foreach ($flashMessages as $key => &$flashMessage) {
             if ($flashMessage['remove']) {
                 unset($flashMessages[$key]);
             }
         }
 
         // Save the updated flash messages back to the session
         $_SESSION[self::FLASH_MESSAGE_KEY] = $flashMessages;
     }
 }