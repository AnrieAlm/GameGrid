
<?php
// Start a session to access user data stored in the session
session_start();

// Include the database connection file (db.php)
require 'db.php';

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get the logged-in user's ID from the session
    $user_id = $_SESSION['user_id'];

    // Retrieve form inputs for current password, new password, and confirm password
    $current_password = $_POST['current-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    // Prepare SQL query to fetch the user's record by their ID
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");

    // Execute the query with the user's ID as a parameter
    $stmt->execute(['user_id' => $user_id]);

    // Fetch the user's record from the database
    $user = $stmt->fetch();

    // Verify if the entered current password matches the hashed password in the database
    if (password_verify($current_password, $user['password_hash'])) {

        // Check if the new password and confirm password match
        if ($new_password === $confirm_password) {

            // Hash the new password using PASSWORD_DEFAULT algorithm
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

            // Prepare SQL query to update the user's password hash in the database
            $stmt = $pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE id = :user_id");

            // Execute the query with the new password hash and user ID as parameters
            $stmt->execute(['password_hash' => $new_password_hash, 'user_id' => $user_id]);

            // Display a success message if the password is updated
            echo "Password updated successfully.";
        } else {
            // Display an error message if the new passwords do not match
            echo "New passwords do not match.";
        }
    } else {
        // Display an error message if the current password is incorrect
        echo "Current password is incorrect.";
    }
}
?>