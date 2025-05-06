<?php

/* file to help save bookmarks in databse */

// bookmark.php

// Include database connection
require_once 'db.php';

session_start();
require 'db.php'; // Database connection

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'];
$gameId = $data['gameId'];
$action = $data['action'];

if (!$userId || !$gameId || !in_array($action, ['add', 'remove'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

try {
    if ($action === 'add') {
        $stmt = $pdo->prepare("INSERT INTO bookmarks (user_id, game_id) VALUES (:user_id, :game_id)");
        $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
    } elseif ($action === 'remove') {
        $stmt = $pdo->prepare("DELETE FROM bookmarks WHERE user_id = :user_id AND game_id = :game_id");
        $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
    }
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>




?>