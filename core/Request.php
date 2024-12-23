<?php

class Request

{    private array $routeParams = [];


    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getUrl()
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    public function isGet()
    {
        return $this->getMethod() === 'get';
    }

    public function isPost()
    {
        return $this->getMethod() === 'post';
    }

    public function get_path()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $postition = strpos($path, '?');
        if ($postition === false) {
            return $path;
        }
        return substr($path, 0, $postition);
    }

    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }


    function validateCsrfToken($token)
    {

    }
   public function getBody()
    {
        // filter_input_array — Gets external variables and optionally filters them  preventing xss attacks
        $body = [];
        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() === 'post') {

            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
    public function setRouteParams($params)
    {
        $this->routeParams = $params;
        return $this;
    }

    public function getRouteParams()
    {
        return $this->routeParams;
    }

    public function getRouteParam($param, $default = null)
    {
        return $this->routeParams[$param] ?? $default;
    }


}