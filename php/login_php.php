<?php
// Start a session to store user data
session_start();

// Include the database connection file
require 'db.php'; // Database connection

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Handle login form submission
    if (isset($_POST['login'])) {
        $username = $_POST['username']; // Get username from form
        $password = $_POST['password']; // Get password from form

        // Prepare SQL query to fetch user by username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]); // Execute query with username parameter
        $user = $stmt->fetch(); // Fetch the user record

        // Verify password using password_verify()
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            $_SESSION['username'] = $user['username']; // Store username in session
            header("Location: profile.html"); // Redirect to profile page
            exit;
        } else {
            echo "Invalid username or password."; // Show error message
        }
    }

    // Handle logout form submission
    if (isset($_POST['logout'])) {
        session_destroy(); // Destroy the session
        header("Location: login.html"); // Redirect to login page
        exit;
    }
}
?>