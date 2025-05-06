<?php


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

// // Check if the user is logged in
// // session_start();
// // if (!isset($_SESSION['user_id'])) {
// //     http_response_code(401); // Unauthorized
// //     echo json_encode(['success' => false, 'message' => 'User not logged in']);
// //     exit;
// // }

// // Get POST data
// $userId = $_SESSION['user_id'];
// $gameId = $_POST['game_id'];

// // Validate input
// if (!is_numeric($gameId)) {
//     http_response_code(400); // Bad Request
//     echo json_encode(['success' => false, 'message' => 'Invalid game ID']);
//     exit;
// }

// // Check if the game exists
// $stmt = $pdo->prepare("SELECT id FROM games WHERE id = :game_id");
// $stmt->execute(['game_id' => $gameId]);
// if (!$stmt->fetch()) {
//     http_response_code(404); // Not Found
//     echo json_encode(['success' => false, 'message' => 'Game not found']);
//     exit;
// }

// // Check if the bookmark already exists
// $stmt = $pdo->prepare("SELECT * FROM bookmarks WHERE user_id = :user_id AND game_id = :game_id");
// $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
// $bookmarkExists = $stmt->fetch();

// if ($bookmarkExists) {
//     // Remove the bookmark
//     $stmt = $pdo->prepare("DELETE FROM bookmarks WHERE user_id = :user_id AND game_id = :game_id");
//     $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
//     echo json_encode(['success' => true, 'action' => 'removed']);
// } else {
//     // Add the bookmark
//     $stmt = $pdo->prepare("INSERT INTO bookmarks (user_id, game_id) VALUES (:user_id, :game_id)");
//     $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
//     echo json_encode(['success' => true, 'action' => 'added']);
// }




?>