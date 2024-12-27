<?php

namespace Models;

use API\GridApi;
use Application;
use Exception;
use Model;
use Request;

class Grid extends Model
{
    const RULE_NUMERIC = 'numeric';
    const RULE_JSON_VALID = 'json_valid';
    const RULE_GRID_STRUCTURE = 'grid_structure';
    public $user_id;
    public $title;
    public $description;
    public $row_size;
    public $col_size;
    public $grid_data;

    public $gridApi;

    public function __construct()
    {
        $this->gridApi = new GridApi();
    }


    public function getAllGrids()
    {
        $grids = $this->gridApi->getGrids();
        return $grids;
    }

    public function getGridById($id)
    {
        $grid = $this->gridApi->getGridById($id);
        return $grid;
    }

    public function create(): void
    {
        if ($this->title === null || $this->description === null || $this->row_size === null || $this->col_size === null || $this->grid_data === null) {
            http_response_code(422);
            echo json_encode(['message' => 'Missing required fields']);
            return;
        }

        $data = [
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'row_size' => $this->row_size,
            'col_size' => $this->col_size,
            'grid_data' => $this->grid_data,
        ];

        try {
             $this->gridApi->addGrid($data);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => $e->getMessage()]);
        }
    }
}
