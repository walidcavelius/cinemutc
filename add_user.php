<?php
// add_user.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../app/config/database.php';
require_once '../app/models/User.php';

use App\Models\User;

$userModel = new User($pdo);

// Example of adding a user
$userModel->create('John Doe', 'john@example.com', 'password123');