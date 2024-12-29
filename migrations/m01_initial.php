<?php

class m01_initial
{
    public function up()
    {
        $db = Application::$app->db;

        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            name VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('user', 'admin') DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";

        $db->pdo->prepare($sql)->execute();

         // Insérer un utilisateur avec le rôle d'administrateur
         $username = 'admin';
         $password = password_hash('admin_password', PASSWORD_BCRYPT); // Assurez-vous de hacher le mot de passe
         $role = 'admin';
 
         $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
         $stmt = $db->pdo->prepare($sql);
         $stmt->bindParam(':username', $username);
         $stmt->bindParam(':password', $password);
         $stmt->bindParam(':role', $role);
         $stmt->execute();

        echo "Table users créée et utilisateur admin ajouté avec succès\n";
    }

    public function down()
    {
        echo "Removing migration\n";
        $db = Application::$app->db;
        $sql = "DROP TABLE users";
        $db->pdo->prepare($sql)->execute();
        echo "table users supprimée avec succès\n";

    }
}