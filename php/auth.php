<?php
// Start a session to store user-specific data (e.g., login status, error messages).
session_start();

// Include the database connection file (`db.php`) to establish a connection to the database.
require 'db.php'; // Database connection

// Handle Login
// Check if the request method is POST and if the 'login' button was submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Retrieve the email and password submitted by the user from the form.
    $username = $_POST['username']; // get username from form
    $password = $_POST['password']; // get pasword from form

    // Prepare a SQL query to fetch the user record from the `users` table based on the provided email.
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");

    // Execute the prepared statement, binding the email parameter to prevent SQL injection.
    $stmt->execute(['username' => $username]);

    // Fetch the user record as an associative array.
    $user = $stmt->fetch();

    // Check if a user with the given email exists and verify the password using `password_verify`.
    if ($user && password_verify($password, $user['password_hash'])) {
        // If login is successful, store the user's ID and username in the session.
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Set a success message in the session to inform the user of a successful login.
        $_SESSION['success'] = "Logged in successfully!";

        // Redirect the user to the profile page after successful login.
        header("Location: profile.php");

        // Terminate the script to ensure no further code is executed.
        exit;
    } else {
        // If login fails, set an error message in the session to inform the user of invalid credentials.
        $_SESSION['error'] = "Invalid email or password.";

        // Redirect the user back to the login page.
        header("Location: login.php");

        // Terminate the script to ensure no further code is executed.
        exit;
    }
}

// Handle Registration
// Check if the request method is POST and if the 'register' button was submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    // Retrieve the full name, username, email, password, and confirm password submitted by the user.
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate that the password and confirm password fields match.
    if ($password !== $confirm_password) {
        // If passwords do not match, set an error message in the session.
        $_SESSION['error'] = "Passwords do not match.";

        // Redirect the user back to the login/registration page.
        header("Location: login.php");

        // Terminate the script to ensure no further code is executed.
        exit;
    }

    // Hash the user's password using PHP's `password_hash` function for secure storage.
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare a SQL query to insert the new user's details into the `users` table.
    $stmt = $pdo->prepare("INSERT INTO users (full_name, username, email, password_hash) VALUES (:full_name, :username, :email, :password_hash)");

    try {
        // Execute the prepared statement, binding the user's details to prevent SQL injection.
        $stmt->execute([
            'full_name' => $full_name,
            'username' => $username,
            'email' => $email,
            'password_hash' => $hashed_password
        ]);

        // Set a success message in the session to inform the user of successful registration.
        $_SESSION['success'] = "Account created successfully! Please log in.";

        // Redirect the user to the login page after successful registration.
        header("Location: login.php");

        // Terminate the script to ensure no further code is executed.
        exit;
    } catch (PDOException $e) {
        // If an exception occurs during the database operation, capture the error message.
        $_SESSION['error'] = "Error: " . $e->getMessage();

        // Redirect the user back to the login/registration page.
        header("Location: login.php");

        // Terminate the script to ensure no further code is executed.
        exit;
    }
}
?>