<?php

require_once __DIR__ .'/../core/Application.php';
require_once __DIR__ .'/../controllers/SiteController.php';
require_once __DIR__ .'/../controllers/AuthController.php';



$app = new Application(dirname(__DIR__));

$app->router->get('/',[Controllers\SiteController::class, 'home']);

$app->router->get('/about', function() { return 'About Us'; });

$app->router->get('/contact',[Controllers\SiteController::class, 'contact']);

$app->router->post('/contact', [Controllers\SiteController::class, 'handleContact']);



// authentification
$app->router->get('/login', [Controllers\AuthController::class, 'login']);
$app->router->post('/login', [Controllers\AuthController::class, 'handlelogin']);

$app->router->get('/register', [Controllers\AuthController::class, 'register']);
$app->router->post('/register', [Controllers\AuthController::class, 'handleRegister']);

$app->run();

?>