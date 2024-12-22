<?php
class  m03_initial
{
    public function up()
    {
        $db = Application::$app->db;

        $sql = "CREATE TABLE saved_games (
                    id INT AUTO_INCREMENT PRIMARY KEY, -- Identifiant unique de la sauvegarde
                    user_id INT NOT NULL, -- Identifiant de l'utilisateur
                    grid_id INT NOT NULL, -- Identifiant de la grille (référence à la table grids)
                    progress_data TEXT NOT NULL, -- JSON représentant l'état actuel de la partie
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date de création
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Dernière mise à jour
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, -- Liaison avec users
                    FOREIGN KEY (grid_id) REFERENCES grids(id) ON DELETE CASCADE -- Liaison avec grids
                ) ENGINE=INNODB;";

        $db->pdo->prepare($sql)->execute();
        echo  "table saved_games crée avec succès\n";
    }

    public function down()
    {
        echo "Removing migration 00\n";
        $db = Application::$app->db;
        $sql = "DROP TABLE saved_games";
        $db->pdo->prepare($sql)->execute();
        echo "table saved_games supprimée avec succès\n";
    }
}