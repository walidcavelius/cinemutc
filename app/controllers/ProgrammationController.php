<?php
$movies = Film::getRecentFilms(6);

require BASE_PATH . '/app/views/programmation.php';