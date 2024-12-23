<?php
require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/Response.php';
class Router
{

    public Request $request;
    public Response $response;
    protected array $routes = [];
    function __construct (Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }
    public function getRouteMap($method): array
    {
        return $this->routes[$method] ?? [];
    }
    public function getCallback()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        // Trim slashes
        $url = trim($url, '/');

        // Get all routes for current request method
        $routes = $this->getRouteMap($method);

        $routeParams = false;
        // Start iterating registed routes
        foreach ($routes as $route => $callback) {
            // Trim slashes
            $route = trim($route, '/');
            $routeNames = [];


            if (!$route) {
                continue;
            }

            // Find all route names from route and save in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }


            // Convert route name into regex pattern
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . "$@";
            // Test and match current route against $routeRegex
            if (preg_match_all($routeRegex, $url, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);
                var_dump($routeParams);
                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }

        return false;
    }
    public function resolve()
    {
        $path = $this->request->get_path();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? null;

        if (!$callback) {
            $callback = $this->getCallback();
            if(!$callback){
                $this->response->setStatusCode(404);
                return $this->renderView("_404");
            }

        }


        $this->executeCallback($callback);
    }

    private function executeCallback($callback)
    {
        if (is_string($callback)) {
             $this->renderView($callback);
        }
        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }
        return call_user_func($callback, $this->request, $this->response);
    }

    public function renderView($view,$prams = [])
    {
        // rendre la view dans un layout
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view,$prams);
        echo str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function layoutContent() : string
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/main.php";
        return ob_get_clean();
    }

    public function renderOnlyView($view,$prams): string
    {
        foreach ($prams as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }


}