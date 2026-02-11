<?php

namespace App\Controller;
use App\Core\View;
use App\Service\SwapiService;
use App\Model\Log;

class CharacterController extends BaseController
{
    public function index() :string
    {
        try {
            return View::render("characters/index");
        } catch (\Exception $e) {
            error_log("Erro ao renderizar a view de personagens: " . $e->getMessage());
            http_response_code(500);
            return View::render("errors/500");
        }

    }

    public function show(int $id) :string
    {
        try{
            return View::render("characters/show", ['id' => $id]);
        } catch(\Exception $e){
            error_log("Erro ao renderizar a view do personagem: " . $e->getMessage());
            return View::render("errors/500");
        }

    }
    public function listCharacters() :void
    {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $swapiService = new SwapiService();
            $characters = $swapiService->fetchAllCharacters($page);
            $this->jsonResponse([
                'success' => true,
                'data' => $characters,
            ], 200);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Failed to fetch characters'
            ], 500);
        }
    }
    public function getCharacter(int $id) :void
    {
        try {
            $swapiService = new SwapiService();
            $characters = $swapiService->fetchCharacterById($id);
            $this->jsonResponse([
                'success' => true,
                'data' => $characters,
            ], 200 );
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Failed to fetch character'
            ], 500);
        }
    }
}