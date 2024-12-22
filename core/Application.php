<?php
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/Response.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../api/GridApi.php'; // Include the GridApi

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public Database $db;

    protected array $middlewares = [];
    public function addMiddleware($middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public static  string $ROOT_DIR;
    public function __construct($routePath)
    {
        self::$ROOT_DIR = $routePath;

        self::$app= $this;

        $this->response = new Response();
        $this->request = new Request();

        $this->router = new Router($this->request, $this->response);

        $this->db = new Database();
    }

    public function run(): void
    {
         $this->router->resolve();
    }
}
?>