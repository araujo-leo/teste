<?php
use App\Core\Router;
use App\Controller\FilmController;
use App\Controller\CharacterController;
use App\Controller\PlanetController;
use App\Controller\SpeciesController;
use App\Controller\StarshipController;
use App\Controller\VehicleController;



$router->get('/characters', [CharacterController::class, 'index']);
$router->get('/characters/{id}', [CharacterController::class, 'show']);



