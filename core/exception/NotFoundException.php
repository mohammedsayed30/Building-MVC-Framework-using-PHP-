<?php

namespace app\core\exception;

/**
 * this for any Not Exsits Requests
 */

class NotFoundException extends \Exception
{

    /**
     * The exception message.
     *
     * Overrides the default message from the parent \Exception class.
     *
     * @var string
     */
    protected $message = 'Page Not Found';

    /**
     * The exception code.
     *
     * Overrides the default code from the parent \Exception class.
     * Represents the HTTP 403 Forbidden status code.
     *
     * @var int
     */

    protected $code  = 404;
}