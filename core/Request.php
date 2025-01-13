<?php

namespace app\core;

/**
 * Handles HTTP requests and provides methods to retrieve request data.
 *
 * This class is responsible for extracting information from the HTTP request,
 * such as the request path, method, and sanitized request body.
 *
 * @package app\core
 */
class Request
{
    /** @var Router The router instance associated with this request. */
    public Router $router;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        // Constructor logic (if any) can be added here
    }

    /**
     * Retrieves the request path (URI) without query parameters.
     *
     * @return string The sanitized request path.
     */
    public function getPath()
    {
        // Get the request URI or default to '/'
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // Remove query parameters from the URI
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }

        return $path;
    }

    /**
     * Retrieves the HTTP request method (e.g., GET, POST).
     *
     * @return string The lowercase HTTP method.
     */
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Checks if the request method is GET.
     *
     * @return bool True if the request method is GET, false otherwise.
     */
    public function isGet()
    {
        return $this->getMethod() === 'get';
    }

    /**
     * Checks if the request method is POST.
     *
     * @return bool True if the request method is POST, false otherwise.
     */
    public function isPost()
    {
        return $this->getMethod() === 'post';
    }

    /**
     * Retrieves the sanitized request body.
     *
     * For GET requests, it sanitizes the $_GET superglobal.
     * For POST requests, it sanitizes the $_POST superglobal.
     *
     * @return array An associative array of sanitized request data.
     */
    public function getBody()
    {
        $body = [];

        if ($this->getMethod() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->getMethod() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}