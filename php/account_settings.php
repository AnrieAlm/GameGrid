
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
    $current_password = $_POST['current_password']; // Get current password from form
    $new_password = $_POST['new_password']; // Get new password from form
    $confirm_password = $_POST['confirm_password']; // Get confirm password from form

    // Prepare SQL query to fetch the user's record
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]); // Execute query with user ID
    $user = $stmt->fetch(); // Fetch the user record

    // Verify the current password
    if (password_verify($current_password, $user['password_hash'])) {
        // Check if new passwords match
        if ($new_password === $confirm_password) {
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT); // Hash the new password
            // Prepare SQL query to update the password
            $stmt = $pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE id = :user_id");
            $stmt->execute(['password_hash' => $new_password_hash, 'user_id' => $user_id]); // Execute query with parameters
            echo "Password updated successfully."; // Confirm update
        } else {
            echo "New passwords do not match."; // Show error if passwords don't match
        }
    } else {
        echo "Current password is incorrect."; // Show error if current password is wrong
    }
}
?>
<!-- HTML form for changing password -->
<form method="POST">
    <label>Current Password:</label>
    <input type="password" name="current_password"> <!-- Input field for current password -->
    <label>New Password:</label>
    <input type="password" name="new_password"> <!-- Input field for new password -->
    <label>Confirm Password:</label>
    <input type="password" name="confirm_password"> <!-- Input field for confirm password -->
    <button type="submit">Save</button> <!-- Submit button -->
</form>