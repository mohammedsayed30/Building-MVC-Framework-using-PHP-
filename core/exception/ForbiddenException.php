<?php

namespace app\core\exception;

/**
 * Custom exception class for handling forbidden access errors.
 *
 * This exception is thrown when a user attempts to access a resource
 * they do not have permission to view or interact with.
 *
 * @package YourPackageName
 */

class ForbiddenException extends \Exception
{

    /**
     * The exception message.
     *
     * Overrides the default message from the parent \Exception class.
     *
     * @var string
     */

    protected $message = 'You do not have permission to access this page  ';
    
    /**
     * The exception code.
     *
     * Overrides the default code from the parent \Exception class.
     * Represents the HTTP 403 Forbidden status code.
     *
     * @var int
     */
    
     protected $code=403;
}