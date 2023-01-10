<?php

namespace App\core;

use App\traits\ApiResponse;

class App
{
    use ApiResponse;

    /**
     * @var array
     */
    public static array $routes = [];

    /**
     * @var array
     */
    private static array $middlewares = [];

    /**
     * @var $this
     */
    private static $_instance;

    /**
     * @return static
     */
    public static function instance(): static
    {
        if (static::$_instance === null) {
            static::$_instance = new static;
        }

        return static::$_instance;
    }

    /**
     * @param $middlewares
     * @return static
     */
    public static function middlewares($middlewares): static
    {
        static::$middlewares = $middlewares;

        return new static;
    }

    /**
     * Add GET route
     *
     * @param $uri
     * @param $controller
     * @param $action
     * @return App
     */
    public static function get($uri, $controller, $action)
    {
        static::add($uri, $controller, $action, 'get');

        return new static;
    }

    /**
     * Add POST route
     *
     * @param $uri
     * @param $controller
     * @param $action
     * @return App
     */
    public static function post($uri, $controller, $action)
    {
        static::add($uri, $controller, $action, 'post');

        return new static;
    }

    /**
     * Add PUT route
     *
     * @param $uri
     * @param $controller
     * @param $action
     * @return App
     */
    public static function put($uri, $controller, $action)
    {
        static::add($uri, $controller, $action, 'put');

        return new static;
    }

    /**
     * Add DELETE route
     *
     * @param $uri
     * @param $controller
     * @param $action
     * @return App
     */
    public static function delete($uri, $controller, $action)
    {
        static::add($uri, $controller, $action, 'delete');

        return new static;
    }

    /**
     * Add route
     *
     * @param $uri
     * @param $controller
     * @param $action
     * @param $method
     * @return App
     */
    public static function add($uri, $controller, $action, $method)
    {
        array_push(static::$routes, [
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        ]);

        return new static;
    }

    /**
     * Start router
     *
     * @param string|null $basePath
     * @throws \ReflectionException
     */
    public function run(string $basePath = null)
    {
        global $user;
        $response = null;
        $grantAccess = true;
        $route_match_found = false;
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);

        require ROOT_DIRECTORY . '/src/config/routes.php';

        $path = $parsed_url['path'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];
        $middlewares = require ROOT_DIRECTORY . '/src/config/middlewares.php';

        foreach (self::$routes as $route) {
            $uri = $route['uri'];

            if (!empty($basePath) && $basePath !== '/') {
                $route['uri'] = '(' . $basePath . ')' . $route['uri'];
            }

            $route['uri'] = '^' . $route['uri'];
            $route['uri'] = $route['uri'] . '$';

            if (preg_match('#' . $route['uri'] . '#', $path, $matches)) {

                if (strtolower($method) == strtolower($route['method'])) {

                    array_shift($matches);

                    if (!empty($basePath) && $basePath !== '/') {
                        array_shift($matches);
                    }

                    foreach (static::$middlewares as $middleware) {
                        $handle = new \ReflectionMethod($middlewares[$middleware], 'handle');

                        $grantAccess = $grantAccess && $handle->invoke(
                            new $middlewares[$middleware],
                            $route,
                            $uri
                        );
                    }

                    if ($grantAccess === true) {
                        try {
                            $method = new \ReflectionMethod($route['controller'], $route['action']);
                            if ($method->getNumberOfParameters() === count($matches)) {
                                $response = $method->invokeArgs(new $route['controller'], $matches);
                                $route_match_found = true;
                                break;
                            }
                        } catch (\ReflectionException $e) {
                            $route_match_found = false;
                        }
                    }
                }
            }
        }

        if ($grantAccess === false) {
            $response = $this->unauthorized();
        } else if ($route_match_found === false) {
            $response = $this->notFound();
        }

        echo $response;
    }
}
