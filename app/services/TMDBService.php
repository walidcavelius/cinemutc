<?php

class TMDBService
{
    private $apiKey;
    private $baseUrl = 'https://api.themoviedb.org/3';

    public function __construct()
    {
        $this->apiKey = $_ENV['TMDB_API_KEY'];
    }

    public function searchMovie($title)
    {
        $url = $this->baseUrl . "/search/movie?api_key={$this->apiKey}&query=" . urlencode($title);
        return $this->makeRequest($url);
    }

    public function getMovieDetails($tmdbId, $language = 'fr')
    {
        $url = $this->baseUrl . "/movie/{$tmdbId}?api_key={$this->apiKey}&language={$language}&append_to_response=credits";
        return $this->makeRequest($url);
    }

    public function getImageUrl($path, $size = 'w1280')
    {
        return "https://image.tmdb.org/t/p/{$size}{$path}";
    }

    public function searchMovies($query)
    {
        $url = $this->baseUrl . "/search/movie?api_key={$this->apiKey}&language=fr&query=" . urlencode($query);
        $results = $this->makeRequest($url);
        
        // Return only the data we need
        return array_map(function($movie) {
            return [
                'id' => $movie['id'],
                'title' => $movie['title'],
                'release_date' => isset($movie['release_date']) ? $movie['release_date'] : 'N/A',
                'poster_path' => isset($movie['poster_path']) ? $this->getImageUrl($movie['poster_path'], 'w92') : null,
                'overview' => isset($movie['overview']) ? $movie['overview'] : ''
            ];
        }, $results['results']);
    }

    public function getMovieById($id) {
        $url = $this->baseUrl . "/movie/{$id}?api_key={$this->apiKey}&language=fr";
        $movie = $this->makeRequest($url);
        
        if (!isset($movie['id'])) {
            return null;
        }

        return [
            'id' => $movie['id'],
            'title' => $movie['title'],
            'release_date' => isset($movie['release_date']) ? $movie['release_date'] : 'N/A',
            'poster_path' => isset($movie['poster_path']) ? $this->getImageUrl($movie['poster_path'], 'w92') : null,
            'overview' => isset($movie['overview']) ? $movie['overview'] : ''
        ];
    }

    private function makeRequest($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}