<?php

namespace API;

class UserApi
{
    private $db;

    public function __construct()
    {
        $this->db = \Application::$app->db;
    }

    public function  addUser($data)
    {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];

        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $req = $this->db->prepare($sql);
        $req->bindParam(':name', $name);
        $req->bindParam(':email', $email);
        $req->bindParam(':password', $password);
        return $req->execute();
    }

    public function login($data)
    {
        echo 'login in api';
        $email = $data['email'];
        $password = $data['password'];
        var_dump($email, $password);

        $sql = "SELECT * FROM users WHERE email = :email";
        $req = $this->db->prepare($sql);
        $req->bindParam(':email', $email);
        $req->execute();
        $user = $req->fetch();
        // afficher les donéne de l'utilisateur pour le test
         var_dump($user);

        if ($user && password_verify($password, $user['password'])) {
            echo 'Success login in api';
            return $user;
        }
        echo 'faild login in api';
        return false;
    }

    public function getUsers()
    {
        $sql = "SELECT * FROM users";
        $req = $this->db->prepare($sql);
        $req->execute();
        $users = $req->fetchAll();
        return $users;

    }

    public function getUserByMail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user;
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

    }
}