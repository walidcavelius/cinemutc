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

    private function makeRequest($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}