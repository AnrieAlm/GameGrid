<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];
try {
    $stmt = $pdo->prepare("
        SELECT g.id, g.title, g.image_url 
        FROM bookmarks b
        JOIN games g ON b.game_id = g.id
        WHERE b.user_id = :user_id
    ");
    $stmt->execute(['user_id' => $userId]);
    $bookmarks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'data' => $bookmarks]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>