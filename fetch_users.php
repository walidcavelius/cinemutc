<?php
// fetch_users.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../app/config/database.php';
require_once '../app/models/User.php';

use App\Models\User;

$userModel = new User($pdo);
$users = $userModel->getAll();

foreach ($users as $user) {
    echo $user['name'] . ' - ' . $user['email'] . '<br>';
}