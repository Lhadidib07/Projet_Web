<?php

namespace Controllers;
use Exception;
use Models\grid;
use Controller;
use Request;


require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Request.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Grid.php';
class GridController extends Controller
{
    public function getGrids(): null
    {
        $gridRepository = new Grid();
        $grids = $gridRepository->getAllGrids(); // Retourne toutes les grilles
        $this->render('grid/grids', ['grids' => $grids]);
        return null;
    }

    public function getGrid(Request $request)
    {
        $gridRepository = new Grid();

        $routeParams = $request->getRouteParams();
        $id = $routeParams['id'] ?? null;
        $grid = $gridRepository->getGridById($id) ?? null;
        return $this->render('grid/grid', ['grid' => $grid]);
    }

    public function playGrid(Request $request)
    {
        $gridRepository = new Grid();
        $routeParams = $request->getRouteParams();
        $id = $routeParams['id'] ?? null;
        $grid = $gridRepository->getGridById($id) ?? null;
        return $this->render('grid/playGrid', ['grid' => $grid]);
    }


    public function getForm()
    {
        $gridRepository = new Grid();
        return $this->render('grid/create', ['model' => $gridRepository]);
    }

    public function handleCreate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['message' => 'Method not allowed']);
            return;
        }

        $input = file_get_contents('php://input');
        $data = json_decode($input, associative: true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid JSON format']);
            return;
        }

        if (!isset($data['csrf_token']) || $data['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            echo json_encode(['message' => 'Invalid CSRF token']);
            return;
        }

        $title = $data['title'] ?? null;
        $description = $data['description'] ?? null;
        $row_size = $data['row_size'] ?? null;
        $col_size = $data['col_size'] ?? null;
        $gridData = $data['gridData'] ?? null;

        if (!$title || !$description || !$row_size || !$col_size || !$gridData) {
            http_response_code(403);
            echo json_encode(['message' => 'All fields are required']);
            return;
        }

        // Create a new grid
        $gridRepository = new Grid();
        $gridRepository->user_id = $_SESSION['user_id'];
        $gridRepository->title = $title;
        $gridRepository->description = $description;
        $gridRepository->row_size = $row_size;
        $gridRepository->col_size = $col_size;
        $gridRepository->grid_data = $gridData;

        if($gridRepository->user_id == null || $gridRepository->title == null || $gridRepository->description == null || $gridRepository->row_size == null || $gridRepository->col_size == null || $gridRepository->grid_data == null){
            http_response_code(200);
            echo json_encode(['message' => 'tous les champs sont requis']);
            return;
        }

        try {
            if($gridRepository->validate()){ 
                $gridRepository->create();
                echo json_encode(['message' => 'Grid created successfully']);
            }
        } catch (Exception $e) {
            http_response_code(200);
            echo json_encode(['message' => $e->getMessage()]);
        }
    }
    public function deleteGrid(Request $request): void
    {
        header('Content-Type: application/json'); // Ensure the response is JSON
    
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid JSON format']);
            return;
        }
    
        if (!isset($data['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $data['csrf_token'])) {
            http_response_code(403);
            echo json_encode(['message' => 'Invalid CSRF token']);
            return;
        }
    
        $id = $data['id'] ?? null;
    
        if (!$id) {
            http_response_code(400);
            echo json_encode(['message' => 'ID field is required']);
            return;
        }
    
        // Debugging: Log the ID and CSRF token
        error_log('ID: ' . $id);
        error_log('CSRF Token: ' . $data['csrf_token']);
    
        $gridRepository = new Grid();
        if ($gridRepository->deleteById($id)) {
            echo json_encode(['message' => 'Grid deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete grid']);
        }
    }

    

}