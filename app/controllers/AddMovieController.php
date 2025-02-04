<?php

namespace App\Controllers;

class AddMovieController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id'])) {
            header('Location: /cinemutc/login');
            exit;
        }

        // Get user role
        $stmt = $this->pdo->prepare('SELECT role FROM users WHERE id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        if ($user['role'] !== 'admin') {
            http_response_code(403);
            require BASE_PATH . '/app/views/403.php';
            exit;
        }
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleSubmission();
        } else {
            $pdo = $this->pdo;
            require BASE_PATH . '/app/views/add_movie.php';
        }
    }

    private function handleSubmission() {
        $tmdb_id = $_POST['tmdb_id'];
        $semestre = $_POST['semestre'];
        $date_projection = $_POST['date_projection'];

        $stmt = $this->pdo->prepare('INSERT INTO films (tmdb_id, semestre, date_projection) VALUES (?, ?, ?)');
        $stmt->execute([$tmdb_id, $semestre, $date_projection]);

        header('Location: /cinemutc/programmation');
        exit;
    }
} 