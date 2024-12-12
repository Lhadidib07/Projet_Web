<?php

namespace Models;
use Model;

require_once  __DIR__ .'/../core/Model.php';

class RegisterModel extends Model
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

    public function register()
    {
        // utilisé l'api userRepository pour enregistrer l'utilisateur
        echo 'Creating new user';
        return true;
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