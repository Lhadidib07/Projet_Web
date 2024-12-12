<?php

class m0001_initial
{
    public function up()
    {
        $db = Application::$app->db;

        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('user', 'admin') DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";

        $db->pdo->prepare($sql)->execute();
        echo  "table users crée avec succès\n";
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