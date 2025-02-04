<?php

class ArchiveController {
    public function index($requestUri) {
        // Parse the request URI
        $parsedUrl = parse_url($requestUri);
        $path = $parsedUrl['path'];
        parse_str(isset($parsedUrl['query']) ? $parsedUrl['query'] : '', $queryParams);

        // Always get semesters
        $semestres = Film::getAllSemesters();

        // Initialize $films
        $films = [];

        // Check if a semester is selected
        if (isset($queryParams['semestre']) && $queryParams['semestre'] !== '') {
            $semester = $queryParams['semestre'];
            $films = Film::getFilmsBySemester($semester);
            error_log("Films for semester $semester: " . print_r($films, true));
        }

        // Ensure $films is always an array
        $films = is_array($films) ? $films : [];

        // Check if it's an HTMX request
        if (isset($_SERVER['HTTP_HX_REQUEST'])) {
            // Return only the movie list HTML
            foreach($films as $film) {
                require BASE_PATH . '/app/views/components/film_card.php';
            }
        } else {
            // Regular page load
            require BASE_PATH . '/app/views/archive.php';
        }
    }
}
