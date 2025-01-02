<?php

class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }

    public function json(array $data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function view(string $view, array $params = [])
    {
        extract($params);
        require_once Application::$ROOT_DIR . "/views/$view.php";
    }

    public function viewLayout(string $view, array $params = [])
    {
        extract($params);
        ob_start();
        require_once Application::$ROOT_DIR . "/views/$view.php";
        $content = ob_get_clean();
        require_once Application::$ROOT_DIR . "/views/layouts/main.php";
    }



}