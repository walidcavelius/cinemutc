<?php
// FilmController.php

// Get the full request URI
$request = $_SERVER['REQUEST_URI'];

// Remove the base URL if it exists
$base_url = '/cinemutc';
$request = str_replace($base_url, '', $request);

// Use a regular expression to extract the ID
if (preg_match('/^\/film\/(\d+)$/', $request, $matches)) {
    $tmdb_id = $matches[1]; // The ID is captured in the first parenthesized subpattern
} else {
    // Handle the case where no valid ID is found
    http_response_code(404);
    require BASE_PATH . '/app/views/404.php';
    exit;
}

// Now you can use $id to fetch the film data
$film = Film::getWithTMDBData($tmdb_id);

// Check if the film exists
if (!$film) {
    http_response_code(404);
    require BASE_PATH . '/app/views/404.php';
    exit;
}

// If the film exists, render the view
require BASE_PATH . '/app/views/film.php';
