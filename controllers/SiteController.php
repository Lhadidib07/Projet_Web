<?php

namespace Controllers;

use Application;
use Controller;
use Request;

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Request.php';


class SiteController extends Controller
{
    public function home(): void
    {
        $params = [
            'name' => "the dibs"
        ];
        $this->render('home',$params);
    }

    public function contact(): void
    {

        Application::$app->router->renderView('contact');
    }

    public function handleContact(Request $request): string
    {
        $body = $request->getBody();

        return 'Handling the submitted data';
    }
}