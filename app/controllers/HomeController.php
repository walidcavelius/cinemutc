<?php
global $tmdbService;

$movieId = 26005;

$movieData = $tmdbService->getMovieDetails($movieId);

// Process director information
$directors = [];
foreach ($movieData['credits']['crew'] as $crewMember) {
    if ($crewMember['job'] === 'Director') {
        $directors[] = $crewMember['name'];
    }
}
$directorsString = implode(', ', $directors);

// Prepare data for the view
$viewData = [
    'title' => $movieData['title'],
    'backdropUrl' => $tmdbService->getImageUrl($movieData['backdrop_path']),
    'directors' => $directorsString,
    'releaseYear' => substr($movieData['release_date'], 0, 4),
    'id' => $movieData['id']
];

require BASE_PATH . '/app/views/home.php';