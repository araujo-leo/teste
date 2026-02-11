<?php

namespace App\Service;

use DateTime;
use Exception;

class SwapiService extends BaseApiService
{
    private string $baseUrl;
    private array $tradeFields = [
        'residents',
        'films',
        'characters',
        'planets',
        'starships',
        'vehicles',
        'species',
        'people',
    ];

    private array $routes = [
        'films' => 'films/',
        'characters' => 'people/',
        'planets' => 'planets/',
        'species' => 'species/',
        'starships' => 'starships/',
        'vehicles' => 'vehicles/',
    ];

    public function __construct()
    {
        $this->baseUrl = $_ENV['API_SWAPI'] ?? 'https://swapi.dev/api/';
    }

    public function fetchAllFilms(): array
    {
        $filmData = $this->fetchAll('films');
        if (isset($filmData['results'])) {
            foreach ($filmData['results'] as &$film) {

                if (isset($film['release_date'])) {
                    $releaseDate = new \DateTime($film['release_date']);
                    $diff = $releaseDate->diff(new \DateTime());

                    $film['interval'] = [
                        'years' => $diff->y,
                        'months' => $diff->m,
                        'days' => $diff->d,
                    ];
                }
            }
        }

        return $filmData;
    }

    public function fetchAllCharacters(int $page = 1): array
    {
        return $this->fetchAll('characters', $page);
    }

    public function fetchAllPlanets(int $page): array
    {
        return $this->fetchAll('planets', $page);
    }

    public function fetchAllSpecies(int $page): array
    {
        return $this->fetchAll('species', $page);
    }

    public function fetchAllStarships(int $page): array
    {
        return $this->fetchAll('starships', $page);
    }

    public function fetchAllVehicles($page): array
    {
        return $this->fetchAll('vehicles', $page);
    }

    public function fetchFilmById(int $id): array
    {
        $filmData = $this->fetchById('films', $id);

        if(isset($filmData['release_date'])) {
            $releaseDate = new DateTime($filmData['release_date']);

            $diff = $releaseDate->diff(new DateTime());

            $filmData['interval'] = [
                'years' => $diff->y,
                'months' => $diff->m,
                'days' => $diff->d,
            ];
        }

        return $filmData;
    }

    public function fetchCharacterById(int $id): array
    {
        return $this->fetchById('characters',$id);
    }

    public function fetchPlanetById(int $id): array
    {
        return $this->fetchById('planets',$id);
    }

    public function fetchSpecieById(int $id): array
    {
        return $this->fetchById('species',$id);
    }

    public function fetchStarshipById(int $id): array
    {
        return $this->fetchById('starships',$id);
    }

    public function fetchVehicleById(int $id): array
    {
        return $this->fetchById('vehicles',$id);
    }

    private function fetchAll(string $routeKey, int $page = 1): array
    {
        $url = $this->baseUrl . $this->routes[$routeKey] . '?page=' . $page;
        $data = $this->request($url);

        $appUrl = $_ENV['APP_URL'] ?? 'http://localhost:8000';
        $resourcePath = rtrim($this->routes[$routeKey], '/');

        if (!empty($data['next'])) {
            $query = parse_url($data['next'], PHP_URL_QUERY);
            $data['next'] = "{$appUrl}/api/{$resourcePath}?{$query}";
        }

        if (!empty($data['previous'])) {
            $query = parse_url($data['previous'], PHP_URL_QUERY);
            $data['previous'] = "{$appUrl}/api/{$resourcePath}?{$query}";
        }

        foreach ($data['results'] as &$item) {
            $id = $this->extractIdFromUrl($item['url']);
            $item['id'] = $id;
            $item['url'] = "{$appUrl}/api/{$resourcePath}/{$id}";

            foreach ($this->tradeFields as $field) {

                if (isset($item[$field]) && is_array($item[$field])) {
                    $item[$field] = $this->enrichListWithLocalUrls($item[$field]);
                }
            }
        }

        return $data;
    }

    private function fetchById(string $route, int $id): array
    {
        $url = $this->baseUrl . $this->routes[$route] . $id . '/';
        $data = $this->request($url);
        $data['id'] = $this->extractIdFromUrl($data['url']);

        $url = $_ENV['APP_URL'] ?? 'http://localhost:8000/';

        $path = rtrim ($this->routes[$route], '/');

        $data['url'] = $url . $path . '/' . $data['id'];

        foreach($this->tradeFields as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                $data[$field] = $this->enrichListWithLocalUrls($data[$field]);
            }
        }

        return $data;
    }


}