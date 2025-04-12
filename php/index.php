<?php

// Include database connection
require_once 'db.php';

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Get POST data
$userId = $_SESSION['user_id'];
$gameId = $_POST['game_id'];

// Check if the game exists
$stmt = $pdo->prepare("SELECT id FROM games WHERE id = :game_id");
$stmt->execute(['game_id' => $gameId]);
if (!$stmt->fetch()) {
    http_response_code(404); // Not Found
    echo json_encode(['success' => false, 'message' => 'Game not found']);
    exit;
}

// Check if the bookmark already exists
$stmt = $pdo->prepare("SELECT * FROM bookmarks WHERE user_id = :user_id AND game_id = :game_id");
$stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
$bookmarkExists = $stmt->fetch();

if ($bookmarkExists) {
    // Remove the bookmark
    $stmt = $pdo->prepare("DELETE FROM bookmarks WHERE user_id = :user_id AND game_id = :game_id");
    $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
    echo json_encode(['success' => true, 'action' => 'removed']);
} else {
    // Add the bookmark
    $stmt = $pdo->prepare("INSERT INTO bookmarks (user_id, game_id) VALUES (:user_id, :game_id)");
    $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
    echo json_encode(['success' => true, 'action' => 'added']);
}

?>