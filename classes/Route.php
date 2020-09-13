<?php

namespace classes;

class Route
{
    private static $routes = [];
    private static $methodNotAllowed = null;

    public static function add($expression, $function, $method = 'get')
    {
        array_push(self::$routes, [
            'expression' => $expression,
            'function' => $function,
            'method' => $method,
        ]);
    }

    public static function methodNotAllowed($function)
    {
        self::$methodNotAllowed = $function;
    }

    public static function run()
    {
        $path = strtok($_SERVER['REQUEST_URI'], '?');

//        echo '<pre>'; print_r($path); echo '</pre>';
        // Get current request method
        $method = $_SERVER['REQUEST_METHOD'];
        $path_match_found = false;
        $route_match_found = false;

        foreach (self::$routes as $route) {
            // Check path match
            if (preg_match('#^'.$route['expression'].'$#', $path,$matches)) {
                array_shift($matches);// Always remove first element. This contains the whole string
                $path_match_found = true;

                // Check method match
                if (strtolower($method) == strtolower($route['method'])) {
                    if (is_string($route['function'])) {
                        list($controller, $function) = explode('@', $route['function']);
                        $class = "\\src\\Controllers\\".$controller;
                        call_user_func([new $class(), $function]);
                    } else {
                        call_user_func_array($route['function'], $matches);
                    }

                    $route_match_found = true;

                    // Do not check other routes
                    break;
                }
            }
        }

        // No matching route was found
        if (!$route_match_found) {
            // But a matching path exists
            if ($path_match_found) {
                header("HTTP/1.0 405 Method Not Allowed");
                if (self::$methodNotAllowed) {
                    call_user_func_array(self::$methodNotAllowed, [$path, $method]);
                }
            } else {
                header("HTTP/1.0 404 Not Found");
            }
        }
    }
}