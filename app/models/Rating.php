<?php
class Rating {
    public function addRating($userId, $movieId, $rating, $review) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO ratings (user_id, movie_id, rating, review) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE rating = VALUES(rating), review = VALUES(review)");
        $stmt->execute([$userId, $movieId, $rating, $review]);
    }
    public function getAverageRating($movieId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT AVG(rating) as avg_rating FROM ratings WHERE movie_id = ?");
        $stmt->execute([$movieId]);
        $result = $stmt->fetch();
        return number_format((float)$result['avg_rating'], 2, '.', '');
    }
    public function userHasRated($userId, $movieId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM ratings WHERE user_id = ? AND movie_id = ?");
        $stmt->execute([$userId, $movieId]);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }

    public function getReviews($movieId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT user_id, rating, review, users.name FROM ratings JOIN users on user_id = users.id WHERE movie_id = ?");
        $stmt->execute([$movieId]);
        return $stmt->fetchAll();
    }
}
