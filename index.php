<?php
// index.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', realpath(dirname(__FILE__)));
require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/app/config/app.php';

$request = $_SERVER['REQUEST_URI'];
$request_path = preg_replace('/\?.*$/', '', $request);
$request = preg_replace('#^/cinemutc/?#', '/', $request_path);

// Special handling for OAuth callback
if (strpos($request_path, '/cinemutc/auth/callback') === 0) {
    require BASE_PATH . '/app/controllers/LoginController.php';
    $controller = new App\Controllers\LoginController($pdo);
    $controller->callback();
    exit;
}

switch ($request) {
  case '/':
  case '':
    require BASE_PATH . '/app/controllers/HomeController.php';
    break;

  case '/add_user':
    require BASE_PATH . '/add_user.php';
    break;

  case '/fetch_users':
    require BASE_PATH . '/fetch_users.php';
    break;

  case '/rate_movie':
    require BASE_PATH . '/rate_movie.php';
    break;

  case '/login':
    require BASE_PATH . '/app/controllers/LoginController.php';
    $controller = new \App\Controllers\LoginController($pdo);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $controller->login();
    } else {
      $controller->showLoginForm();
    }
    break;

    // Add new OAuth routes
  case '/auth/login':
    require BASE_PATH . '/app/controllers/LoginController.php';
    $controller = new \App\Controllers\LoginController($pdo);
    $controller->login();  // This will now handle OAuth login
    break;

  case '/auth/callback':
    require BASE_PATH . '/app/controllers/LoginController.php';
    $controller = new \App\Controllers\LoginController($pdo);
    $controller->callback();
    break;

  case '/logout':
    require BASE_PATH . '/app/controllers/LoginController.php';
    $controller = new \App\Controllers\LoginController($pdo);
    $controller->logout();
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

  case '/add-movie':
    require BASE_PATH . '/app/controllers/AddMovieController.php';
    $controller = new \App\Controllers\AddMovieController($pdo);
    $controller->index();
    break;

  case '/api/search-movies':
    require BASE_PATH . '/app/controllers/ApiController.php';
    $controller = new \App\Controllers\ApiController();
    $controller->searchMovies();
    break;

  default:
    // Check if the request is for a static file
    if (file_exists(__DIR__ . $request)) {
      return false; // Let the web server handle the request
    } else {
      error_log("404 Not Found: " . $request); // Debug log
      http_response_code(404);
      require BASE_PATH . '/app/views/404.php';
    }
    break;
}
