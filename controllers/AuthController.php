<?php

namespace Controllers;

use Application;
use Controller;
use http\Env\Response;
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

    public function logout(Request $request)
    {
        try {
            // Verify the validity of the CSRF token
            if (hash_equals($_SESSION['csrf_token'], $request->getBody()['csrf_token'] ?? '')) {
                // Header to indicate that the response is JSON
                header('Content-Type: application/json');

                // Return a clean JSON response
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid CSRF token',
                ]);

                // End the script to avoid any additional output
                exit;
            } else {
                // Destroy the session
                session_unset();
                session_destroy();

                // Header to indicate that the response is JSON
                header('Content-Type: application/json');

                // Return a clean JSON response
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Logout successful',
                ]);

                // End the script to avoid any additional output
                exit;
            }
        } catch (\Exception $e) {
            // Header to indicate that the response is JSON
            header('Content-Type: application/json');

            // Return a clean JSON response in case of error
            echo json_encode([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ]);

            // End the script to avoid any additional output
            exit;
        }
    }
    public function handlelogin(Request $request)
    {


        $userData = new User();
        $userData->loadData($request->getBody());


        if (!$userData->login()) {
            return $this->render('login', ['model' => $userData]);
        }

        $_SESSION['user_id'] = $userData->id;
        $_SESSION['user_role'] = $userData->role;
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

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