
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

// Prepare SQL query to fetch the user's profile
$stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]); // Execute query with user ID
$profile = $stmt->fetch(); // Fetch the profile record

// Check if the profile exists
if (!$profile) {
    echo "Profile not found."; // Show error message if no profile exists
} else {
    // Display the user's profile information
    echo "<h1>{$profile['username']}</h1>"; // Display username
    echo "<p>{$profile['bio']}</p>"; // Display bio
    echo "<img src='{$profile['avatar_url']}' alt='Profile Picture'>"; // Display avatar
}
?>