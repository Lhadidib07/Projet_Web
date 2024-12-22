<?php

namespace Controllers;

use Application;
use Controller;
use models\User;
use Request;

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Request.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller
{
    public function login(): void
    {
        $this->render('login');
    }

    public function logout()
    {
        // Destroy the session
        session_unset();
        session_destroy();

        return $this->render('home'); // Redirect to the home page or any other page
    }
    public function handlelogin(Request $request)
    {


        $userData = new User();
        $userData->loadData($request->getBody());


        if (!$userData->login()) {
            echo ' Login failed in controller ';
            return $this->render('login', ['model' => $userData]);
        }

        $_SESSION['user_id'] = $userData->id;
        $_SESSION['user_role'] = $userData->role;
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        echo 'Success';
        return $this->render('home'); // Redirect to the home page or any other page
    }

    public function register(): void
    {
        $userData = new User();
        $this->render('register', ['model' => $userData]);
    }

    public function handleRegister(Request $request)
    {
        $userData = new User();
        // il faut validé les données avant de les envoyer à la base de données
        $userData->loadData($request->getBody());
        if ( $userData->validate() && $userData->register() ) {
            //echo 'Success';
            return  $this->render('');
        }else{
            //echo 'Failed';
            return $this->render('register', ['model' => $userData]);
        }

    }

}