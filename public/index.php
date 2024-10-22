<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));

require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/app/config/app.php';

$request = $_SERVER['REQUEST_URI'];
$base_url = '/cinemutc/public';

// Remove base URL from request
$request = str_replace($base_url, '', $request);

switch ($request) {
    case '/':
    case '':
        require BASE_PATH . '/app/controllers/HomeController.php';
        break;
    case (preg_match('/^\/archive/', $request) ? true : false):
        require BASE_PATH . '/app/controllers/ArchiveController.php';
        $controller = new ArchiveController();
        $controller->index($_SERVER['REQUEST_URI']);
        break;
    case (preg_match('/^\/film\/\d+$/', $request) ? true : false):
        require BASE_PATH . '/app/controllers/FilmController.php';
        break;
    case '/infos':
        require BASE_PATH . '/app/controllers/InfoController.php';
        break;
    case '/programmation':
        require BASE_PATH . '/app/controllers/ProgrammationController.php';
        break;
    default:
        // Check if the request is for a static file
        if (file_exists(__DIR__ . $request)) {
            return false; // Let the web server handle the request
        } else {
            http_response_code(404);
            require BASE_PATH . '/app/views/404.php';
        }
        break;
}