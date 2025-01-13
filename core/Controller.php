<?php

/**
 * This class provides a base controller for handling views, layouts, and middleware.
 * It makes accessing methods easier and more readable.
 */
namespace app\core;

use app\core\middlewares\BaseMiddleware;

/**
 * The base Controller class.
 *
 * This class is responsible for managing layouts, rendering views, and registering middleware.
 *
 * @package app\core
 */
class Controller
{
    /** @var string The layout file to be used for rendering views. Default is 'main'. */
    public string $layout = 'main';

    /**
     * @var BaseMiddleware[] Array of middleware objects registered for this controller.
     */
    public array $middlewares = [];

    /** @var string The action (method) being executed in the controller. */
    public string $action = '';

    /**
     * Sets the layout for the controller.
     *
     * @param string $layout The name of the layout file to use.
     */
    public function setLayout(string $layout)
    {
        $this->layout = $layout;
    }

    /**
     * Renders a view with optional parameters.
     *
     * @param string $view The name of the view file to render.
     * @param array $params An associative array of parameters to pass to the view.
     * @return string The rendered view content.
     */
    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }

    /**
     * Registers a middleware for the controller.
     *
     * @param BaseMiddleware $middleware The middleware object to register.
     */
    public function registerMiddleware(BaseMiddleware $middleware)
    {
        // Add the middleware to the middlewares array
        $this->middlewares[] = $middleware;
    }

    /**
     * Returns the array of registered middlewares.
     *
     * @return BaseMiddleware[] The array of middleware objects.
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}