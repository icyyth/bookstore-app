<?php
class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        // 1. Kiểm tra route có tồn tại với method hiện tại không
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            
            if (is_array($handler) && count($handler) === 2) {
                $controllerName = $handler[0];
                $action = $handler[1];
                
                if (is_string($controllerName)) {
                    $controller = new $controllerName();
                } else {
                    $controller = new $controllerName();
                }
                
                $controller->$action();
                return;
            }
        }

        // 2. Kiểm tra route có tồn tại ở method khác không → 405
        foreach ($this->routes as $routeMethod => $methodRoutes) {
            if (isset($methodRoutes[$path])) {
                http_response_code(405);
                view('errors/405');
                return;
            }
        }

        // 3. Route không tồn tại → 404
        http_response_code(404);
        view('errors/404');
    }
}