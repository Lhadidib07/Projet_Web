<?php

namespace Models;

use Model;
use API\UserApi;

require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../api/UserApi.php';

class User extends Model
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
    public string $role = '';

    public  string $id = '';

    public function __construct()
    {
    }

    public function login()
    {
        $userApi = new UserApi();
        $user = $userApi->login([
            'email' => $this->email,
            'password' => $this->password
        ]);
        if ($user) {
            $this->role = $user['role'];
            $this->id = $user['id'];
            return true;
        }else{
            return false;
        }
    
    }

   public function register(): bool
   {
    $userApi = new UserApi();
    $data = [
        'name' => $this->name,
        'email' => $this->email,
        'password' => password_hash($this->password, PASSWORD_BCRYPT)
    ];
    return $userApi->addUser($data);
}

    public function getAllUsers()
    {
        $userApi = new UserApi();
        return $userApi->getUsers();
    }

    public function deleteUser()
    {
        $userApi = new UserApi();
        return $userApi->deleteUser($this->id);
    }

    public function getUserByMail()
    {
        $userApi = new UserApi();
        return $userApi->getUserByMail($this->email);
    }

    

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }
}