
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

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID
    $bio = $_POST['bio']; // Get bio from form
    $avatar_url = $_POST['avatar_url']; // Get avatar URL from form

    // Prepare SQL query to update the user's profile
    $stmt = $pdo->prepare("UPDATE profiles SET bio = :bio, avatar_url = :avatar_url WHERE user_id = :user_id");
    $stmt->execute(['bio' => $bio, 'avatar_url' => $avatar_url, 'user_id' => $user_id]); // Execute query with parameters

    echo "Profile updated successfully."; // Confirm update
}
?>
<!-- HTML form for editing profile -->
<form method="POST">
    <label>Bio:</label>
    <textarea name="bio"></textarea> <!-- Input field for bio -->
    <label>Avatar URL:</label>
    <input type="text" name="avatar_url"> <!-- Input field for avatar URL -->
    <button type="submit">Save</button> <!-- Submit button -->
</form>