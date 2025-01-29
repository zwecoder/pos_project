<?php
namespace app\core;

use app\controllers\HomeController;

class Router
{
    private $routes = [];

    public function get($uri, $controllerAction)
    {
        $this->routes['GET'][$this->formatUri($uri)] = $controllerAction;
    }
    public function post($uri, $controllerAction)
    {
        $this->routes['POST'][$this->formatUri($uri)] = $controllerAction;
    }

    public function dispatch()
    {
        $uri = $this->parseUri();
        $method = $_SERVER['REQUEST_METHOD'];
       
        foreach ($this->routes[$method] as $routeUri => $controllerAction) {
            $pattern = $this->convertToPattern($routeUri);
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove the full match
                return $this->callAction($controllerAction, $matches);
            }
        }

       http_response_code(404);
        echo "404 Not Found";
    }

    private function formatUri($uri)
    {
        return '/' . trim($uri, '/');
    }

    private function parseUri()
    {
        //$uri = $_SERVER['QUERY_STRING'];
       $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return '/' . trim($uri, '/');
       
    }

    private function convertToPattern($routeUri)
    {
        // Escape forward slashes in the route URI to avoid issues in the regex pattern
        $escapedRouteUri = preg_quote($routeUri, '/');

        // Replace {parameter} placeholders with regex pattern to capture parameters
        $pattern = preg_replace('/\\\{[^\}]+\\\}/', '([^\/]+)', $escapedRouteUri);

        // Return the full regex pattern with start and end delimiters
        return "/^" . $pattern . "$/";
    }

    private function callAction($controllerAction, $params)
    {
        list($controller, $action) = explode('@', $controllerAction);
        $controller = trim("app\controllers\ ") . $controller;
     // dd($action.$controller);
       //require_once "../controllers/{$controller}.php";
        $controllerInstance = new $controller;
        //dd($controllerInstance);
        call_user_func_array([$controllerInstance, $action], $params);
    }
}