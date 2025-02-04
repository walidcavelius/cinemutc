<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: /cinemutc/public/login");
  exit;
}

require_once 'app/models/Rating.php';
$ratingModel = new Rating();
$userId = $_SESSION['user_id'];
$movieId = $_POST['movie_id'];
$rating = $_POST['rating'];
$review = $_POST['review'];
$ratingModel->addRating($userId, $movieId, $rating, $review);
exit;

