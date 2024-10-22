<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$dbname = 'cinemutc'; // Replace with your database name
$username = 'root';    // Default XAMPP MySQL username
$password = '';        // Default XAMPP MySQL password (empty)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful!";

    $stmt = $pdo->query('SELECT * FROM films');
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($movies as $movie) {
        echo $movie['titre'], "<br>";
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
