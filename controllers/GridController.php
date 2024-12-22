<?php

namespace Controllers;
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
    public function HandelCreate(Request $request)
    {
        $gridRepository = new Grid();
        $gridRepository->loadData($request->getBody());
        // validation csrf
        if (!hash_equals($_SESSION['csrf_token'], $request->getBody()['csrf_token'])) {
            return $this->render('grid/create', ['model' => $gridRepository]);
        }else{
            if($gridRepository->validate() && $gridRepository->create()){
                // a voir apres pour les notifs
                $_SESSION['success'] = 'Grille ajoutée avec succès';
                return $this->render('grids');
            }
            exit;
        }
    }

    public function delete()
    {
        echo 'delete';
    }


}