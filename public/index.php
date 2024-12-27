<?php

use Controllers\AuthController;

require_once __DIR__ .'/../core/Application.php';
require_once __DIR__ .'/../controllers/SiteController.php';
require_once __DIR__ .'/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/GridController.php'; // Include the GridController

session_start([
    'cookie_lifetime' => 86400, // 1 day
    'cookie_secure' => true, // Only send over HTTPS
    'cookie_httponly' => true, // Not accessible via JavaScript
    'use_strict_mode' => true, // Strict session mode
]);

$app = new Application(dirname(__DIR__));

//static routes
$app->router->get('/',[Controllers\SiteController::class, 'home']);
$app->router->get('/about', function() { return 'About Us'; });
$app->router->get('/contact',[Controllers\SiteController::class, 'contact']);
$app->router->post('/contact', [Controllers\SiteController::class, 'handleContact']);



// authentification
$app->router->get('/login', [Controllers\AuthController::class, 'login']);
$app->router->post('/login', [Controllers\AuthController::class, 'handlelogin']);

$app->router->get('/register', [Controllers\AuthController::class, 'register']);
$app->router->post('/register', [Controllers\AuthController::class, 'handleRegister']);


// gestion des grides
$app->router->get('/grids', [Controllers\GridController::class, 'getGrids']);
$app->router->get('/grids/{id}', [Controllers\GridController::class, 'getGrid']);
$app->router->get('/playGrid/{id}', [Controllers\GridController::class, 'playGrid']);


// a remplacé par un midlware qui redirige vers la page de conexion si l'utilisateur n'est pas connecté
if(isset($_SESSION['user_id'])){
    $app->router->post('/logout', [AuthController::class, 'logout']);
    $app->router->get('/profile', [Controllers\AuthController::class, 'profile']);
    $app->router->post('/profile', [Controllers\AuthController::class, 'updateProfile']);

    $app->router->get('/grid/create', [Controllers\GridController::class, 'getForm']);
    $app->router->post('/grid/create', [Controllers\GridController::class, 'handleCreate']);

    if($_SESSION['user_role']=='admin'){
        $app->router->post('/grids/delete', [Controllers\GridController::class, 'delete']);
        //$app->router->get('/users', [Controllers\UserController::class, 'index']);
        //$app->router->post('/users/delete', [Controllers\UserController::class, 'delete']);
    }

}




$app->run();

?>