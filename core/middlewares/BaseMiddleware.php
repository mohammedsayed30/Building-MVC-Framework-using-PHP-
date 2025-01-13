<?php

namespace app\core\middlewares;

/**
 * Abstract base class for middleware.
 *
 * Middleware classes that extend this class must implement the `execute()` method
 * to define their specific behavior.
 *
 * @package app\core\middlewares
 */
abstract class BaseMiddleware
{
    /**
     * Executes the middleware logic.
     *
     * This method must be implemented by concrete middleware classes to define
     * the specific behavior of the middleware.
     *
     * @return void
     */
    abstract public function execute();
}