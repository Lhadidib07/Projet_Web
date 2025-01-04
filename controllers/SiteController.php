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
        $this->render('home');
    }

}