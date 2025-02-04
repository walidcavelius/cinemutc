<?php

function isAdmin() {
    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    global $pdo;
    $stmt = $pdo->prepare('SELECT role FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    return $user && $user['role'] === 'admin';
} 