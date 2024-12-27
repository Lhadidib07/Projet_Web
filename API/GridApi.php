<?php

namespace API;
use Application;
use PDO;

class GridApi
{
    private $db;

    public function __construct()
    {
        $this->db = \Application::$app->db;
    }
    // Récupérer toutes les grilles
    public function getGrids()
    {
        $sql = "SELECT id, title,description,created_at FROM grids ORDER BY created_at DESC";
        $req = $this->db->prepare($sql);
        $req->execute();
        return $req->fetchAll($this->db->pdo::FETCH_ASSOC);
    }

    // Récupérer une grille par ID
    public function getGridById($id)
    {
        $sql = "SELECT * FROM grids WHERE id = :id";
        $req = $this->db->prepare($sql);
        $req->bindParam(':id', $id);
        $req->execute();
        $grid = $req->fetch($this->db->pdo::FETCH_ASSOC);

        return $grid;
    }


    // Ajouter une nouvelle grille
    public function addGrid($data)
    {
        try {
            $sql = "INSERT INTO grids (user_id, title, description, rows_size, cols_size, grid_data) 
                VALUES (:user_id, :title, :description, :rows_size, :cols_size, :grid_data)";
            $req = $this->db->prepare($sql);

            // Bind des paramètres
            $req->bindParam(':user_id', $data['user_id']);
            $req->bindParam(':title', $data['title']);
            $req->bindParam(':description', $data['description']);
            $req->bindParam(':rows_size', $data['row_size']); // Correspond au champ 'row_size' dans $data
            $req->bindParam(':cols_size', $data['col_size']); // Correspond au champ 'col_size' dans $data
            $json_encode = json_encode($data['grid_data']);
            $req->bindParam(':grid_data', $json_encode); // Convert array to JSON string

            // Exécution de la requête
            $req->execute();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'ajout de la grille : " . $e->getMessage());
        }
    }




    // Mettre à jour une grille existante
    public function updateGrid($id, $data)
    { // a revoir
        try {
            $sql = "UPDATE grids SET title = :title, description = :description, size = :size, difficulty = :difficulty WHERE id = :id";
            $req = $this->db->prepare($sql);
            $req->bindParam(':title', $data['title']);
            $req->bindParam(':description', $data['description']);
            $req->bindParam(':size', $data['size']);
            $req->bindParam(':difficulty', $data['difficulty']);
            $req->bindParam(':id', $id);
            return $req->execute();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la mise à jour de la grille : " . $e->getMessage());
        }
    }

    // Supprimer une grille
    public function deleteGrid($id)
    {
        try {
            $sql = "DELETE FROM grids WHERE id = :id";
            $req = $this->db->prepare($sql);
            $req->bindParam(':id', $id);
            return $req->execute();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la suppression de la grille : " . $e->getMessage());
        }
    }
}