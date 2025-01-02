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
    public function getUsers(): void
    {
        $user = new User();
        $users = $user->getAllUsers();
        $this->render('users', ['users' => $users]);
    }

    public function addUser(Request $request): void
    {
        $userData = new User();
        // il faut validé les données avant de les envoyer à la base de données
        $userData->loadData($request->getBody());
        if ( $userData->validate() && $userData->register() ) {
            //echo 'Success';
            //return  $this->render('');
        }else{
            //echo 'Failed';
            //return $this->render('register', ['model' => $userData]);
        }

    }

    public function deleteUser(Request $request): void
    {
        $user = new User();
        $user->id = $request->getBody()['id'];
        $user->deleteUser();

    }

}