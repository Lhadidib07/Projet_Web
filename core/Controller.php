<?php

require_once __DIR__ .'/../core/Application.php';

class Controller
{

    public function render($view, $params = [])
    {
        return  Application::$app->router->renderView($view, $params);
    }
    
    public function csrfVerification(Request $request): void
    {
        if ($request->getBody()['csrf_token'] !== $_SESSION['csrf_token']) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
            exit;
        }
    }
    
}