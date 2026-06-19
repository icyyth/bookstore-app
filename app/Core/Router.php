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

    if (isset($this->routes[$method][$path])) {
        $handler = $this->routes[$method][$path];
        
        // Xử lý cả 2 cách: [Controller::class, 'action'] hoặc ['Controller', 'action']
        if (is_array($handler) && count($handler) === 2) {
            $controllerName = $handler[0];
            $action = $handler[1];
            
            // Nếu là string (tên class), tạo instance
            if (is_string($controllerName)) {
                $controller = new $controllerName();
            } else {
                $controller = new $controllerName();
            }
            
            $controller->$action();
            return;
        }
    }

    http_response_code(404);
    view('errors/404');
}
}