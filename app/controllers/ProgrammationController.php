<?php
// Check if user is logged in and is admin
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';

$movies = Film::getRecentFilms(6);

require BASE_PATH . '/app/views/programmation.php';
