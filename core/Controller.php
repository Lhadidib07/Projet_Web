<?php

require_once __DIR__ .'/../core/Application.php';

class Controller
{

    public function render($view, $params = [])
    {
        return  Application::$app->router->renderView($view, $params);
    }
}