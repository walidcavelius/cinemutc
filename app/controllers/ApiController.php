<?php

namespace App\Controllers;

class ApiController {
    private $tmdbService;

    public function __construct() {
        $this->tmdbService = new \TMDBService();
    }

    public function searchMovies() {
        header('Content-Type: application/json');
        
        if (!isset($_GET['query'])) {
            echo json_encode(['error' => 'Query parameter is required']);
            return;
        }

        $query = trim($_GET['query']);

        // If query is numeric, try to fetch by ID first
        if (is_numeric($query)) {
            $movie = $this->tmdbService->getMovieById($query);
            if ($movie) {
                echo json_encode([$movie]); // Return as array to maintain consistent format
                return;
            }
        }

        // If not numeric or movie not found by ID, perform regular search
        $results = $this->tmdbService->searchMovies($query);
        echo json_encode($results);
    }
} 