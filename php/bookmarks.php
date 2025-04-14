
<?php
// Start a session to access user data
session_start();

// Include the database connection file
require 'db.php'; // Database connection

// Check if the user is logged in (session exists)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit;
}

// Get the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id']; // Get item ID from form
    $item_type = $_POST['item_type']; // Get item type from form

    // Prepare SQL query to insert a new bookmark
    $stmt = $pdo->prepare("INSERT INTO bookmarks (user_id, item_id, item_type) VALUES (:user_id, :item_id, :item_type)");
    $stmt->execute(['user_id' => $user_id, 'item_id' => $item_id, 'item_type' => $item_type]); // Execute query with parameters

    echo "Bookmark added."; // Confirm bookmark addition
}

// Prepare SQL query to fetch all bookmarks for the user
$stmt = $pdo->prepare("SELECT * FROM bookmarks WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]); // Execute query with user ID
$bookmarks = $stmt->fetchAll(); // Fetch all bookmarks

// Loop through and display each bookmark
foreach ($bookmarks as $bookmark) {
    echo "<li>Item ID: {$bookmark['item_id']} - Type: {$bookmark['item_type']}</li>";
}
?>