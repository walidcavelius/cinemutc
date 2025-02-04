<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../services/TMDBService.php';

// Load all model files
foreach (glob(__DIR__ . '/../models/*.php') as $filename) {
    require_once $filename;
}

$tmdbService = new TMDBService();