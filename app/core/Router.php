<?php
class Router
{
    private $routes = [];

    public function get($uri, $controllerAction)
    {
        $this->routes['GET'][$uri] = $controllerAction;
    }

    // POST route
    public function post($uri, $controllerAction)
    {
        $this->routes['POST'][$uri] = $controllerAction;
    }


    public function dispatch($uri)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] ?? [] as $route => $controllerAction) {
            // Convert (/something/(\d+)) thành regex
            $pattern = '#^' . $route . '$#';
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // bỏ full match
                $parts = explode('@', $controllerAction);
                $controller = $parts[0];
                $action = $parts[1];
                require_once dirname(__DIR__) . '/controllers/' . $controller . '.php';
                $c = new $controller();
                call_user_func_array([$c, $action], $matches); // truyền params
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
