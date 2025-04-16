<?php
// Include database credentials (optional if already defined in game_grid.php)
include 'includes/game_grid.php'; // Ensure this file contains your database credentials

// Start session for user authentication
session_start();

// Database connection details
$host = 'localhost'; // Replace with your database host if different
$dbname = 'game_grid'; // Your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

// Create a new database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if user is logged in (you'll need to implement your login system)
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "You must be logged in to post comments."]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Handling Comment Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'addComment') {
    // Validate inputs
    if (!isset($_POST['gameId'], $_POST['commentText']) || 
        !is_numeric($_POST['gameId']) || 
        empty(trim($_POST['commentText']))) {
        http_response_code(400); // Bad Request
        echo json_encode(["success" => false, "error" => "Invalid input data."]);
        exit;
    }

    $game_id = (int)$_POST['gameId'];
    $comment_text = trim($_POST['commentText']);

    // Insert comment using prepared statement
    $stmt = $conn->prepare("INSERT INTO comments (user_id, game_id, comment_text, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $user_id, $game_id, $comment_text);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Comment added successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "Failed to add comment."]);
    }
    exit;
}

// Handling Comment Editing
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'editComment') {
    // Validate inputs
    if (!isset($_POST['commentId'], $_POST['editedCommentText']) || 
        !is_numeric($_POST['commentId']) || 
        empty(trim($_POST['editedCommentText']))) {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "Invalid input data."]);
        exit;
    }

    $comment_id = (int)$_POST['commentId'];
    $edited_comment_text = trim($_POST['editedCommentText']);

    // Update comment using prepared statement
    $stmt = $conn->prepare("UPDATE comments SET comment_text = ? WHERE comment_id = ? AND user_id = ?");
    $stmt->bind_param("sii", $edited_comment_text, $comment_id, $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Comment updated successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "Failed to update comment."]);
    }
    exit;
}

// Handling Comment Deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'deleteComment') {
    // Validate input
    if (!isset($_POST['commentId']) || !is_numeric($_POST['commentId'])) {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "Invalid input data."]);
        exit;
    }

    $comment_id = (int)$_POST['commentId'];

    // Delete comment using prepared statement
    $stmt = $conn->prepare("DELETE FROM comments WHERE comment_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $comment_id, $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Comment deleted successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "Failed to delete comment."]);
    }
    exit;
}

// Fetching Comments for a Game
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] === 'getComments') {
    // Validate input
    if (!isset($_GET['gameId']) || !is_numeric($_GET['gameId'])) {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "Invalid input data."]);
        exit;
    }

    $game_id = (int)$_GET['gameId'];

    // Fetch comments using prepared statement
    $stmt = $conn->prepare("SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.user_id WHERE game_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
    }
    echo json_encode(["success" => true, "comments" => $comments]);
    exit;
}

// Close the database connection
$conn->close();
?>