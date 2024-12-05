<?php

require_once __DIR__ .'/../core/Application.php';
require_once __DIR__ .'/../controllers/SiteController.php';


$app = new Application(dirname(__DIR__));

$app->router->get('/', "home");

$app->router->get('/about', function() {
    return 'About Us';
});

$app->router->get('/contact',[Controllers\SiteController::class, 'contact']);

$app->router->post('/contact', [Controllers\SiteController::class, 'handleContact']);

$app->run();

?>