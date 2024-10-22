<?php
class Rating {
    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    public function addRating($movieId, $rating) {
        $stmt = $this->db->prepare("INSERT INTO ratings (movie_id, rating) VALUES (?, ?)");
        $stmt->execute([$movieId, $rating]);
    }

    public function getAverageRating($movieId) {
        $stmt = $this->db->prepare("SELECT AVG(rating) as avg_rating FROM ratings WHERE movie_id = ?");
        $stmt->execute([$movieId]);
        $result = $stmt->fetch();
        return $result['avg_rating'];
    }
}
