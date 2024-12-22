<?php
class  m02_initial
{
    public function up()
    {
        $db = Application::$app->db;

        $sql = "CREATE TABLE grids (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            rows_size INT NOT NULL, 
            cols_size INT NOT NULL, 
            grid_data TEXT NOT NULL, -- JSON contient les données de la grille ansi que les énigmes
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=INNODB;";

        $db->pdo->prepare($sql)->execute();
        echo  "table grids créée avec succès\n";
    }

    public function down()
    {
        echo "Removing migration 02\n";
        $db = Application::$app->db;
        $sql = "DROP TABLE grids";
        $db->pdo->prepare($sql)->execute();
        echo "table grids supprimée avec succès\n";
    }
}