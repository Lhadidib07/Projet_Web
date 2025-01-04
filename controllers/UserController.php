<?php

namespace Controllers;

use Application;
use Controller;
use models\User;
use Request;
use Response; 

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Request.php';
require_once __DIR__ . '/../models/User.php';

class UserController extends Controller
{

    public function csrfVerification(Request $request): void
    {
        if ($request->getBody()['csrf_token'] !== $_SESSION['csrf_token']) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
            exit;
        }
    }
    public function getUsers(): void
    {
        $user = new User();
        $users = $user->getAllUsers();
        $this->render('userMangment/users', ['users' => $users]);   
    }

    public function addUser(Request $request): void
    {
        $this->csrfVerification($request);

        $userData = new User();
        // il faut validé les données avant de les envoyer à la base de données
        $userData->loadData($request->getBody());
    
        if ( $userData->validate() && $userData->register() ) {
            unset($userData->password);

            // get user data by email 
            $userData = $userData->getUserByMail(); 
            echo json_encode(['status' => 'success', 'user' => $userData , 'message' => 'User added successfully']);
        }else{ 
            echo json_encode(['status' => 'error', 'message' => 'Failed to add user' , 'errors' => $userData->getErrors()]);
        }

    }
  
    public function deleteUser(Request $request)
    {
        $this->csrfVerification($request);
        
        $user = new User();
        $user->id = $request->getBody()['id'];
        
        if ($user->deleteUser()) {
            echo json_encode(['status' => 'success', 'id' => $user->id , 'message' => 'User deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
        }
    }

}