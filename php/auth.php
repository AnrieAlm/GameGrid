<?php

/* file that authenticates login  */

// Start the session to store user data and messages
session_start();
// Include the database connection file
require_once 'db.php'; // Ensure db.php is in the same directory and contains valid PDO connection
// Function to hash passwords securely using BCRYPT
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT); // Hash the password for secure storage
}
// Function to check if a user with the given email or username already exists
function checkUserExists($pdo, $email, $username) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email OR username = :username"); // Prepare SQL query
    $stmt->execute(['email' => $email, 'username' => $username]); // Execute query with parameters
    return $stmt->rowCount() > 0; // Return true if a matching user exists
}
// Handle Registration Form Submission
if (isset($_POST['register'])) { // Check if the registration form was submitted
    // Sanitize user inputs to prevent XSS attacks
    $fullName = htmlspecialchars(trim($_POST['full_name'])); // Get and sanitize full name
    $username = htmlspecialchars(trim($_POST['username'])); // Get and sanitize username
    $email = htmlspecialchars(trim($_POST['email'])); // Get and sanitize email
    $password = $_POST['password']; // Get password
    $confirmPassword = $_POST['confirm_password']; // Get confirm password
    // Initialize an array to store validation errors
    $errors = [];
    // Validate Full Name
    if (empty($fullName)) { // Check if full name is empty
        $errors[] = "Full name is required.";
    }
    // Validate Username
    if (empty($username)) { // Check if username is empty
        $errors[] = "Username is required.";
    }
    // Validate Email
    if (empty($email)) { // Check if email is empty
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Validate email format
        $errors[] = "Invalid email format.";
    }
    // Validate Password
    if (empty($password)) { // Check if password is empty
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) { // Ensure password is at least 6 characters long
        $errors[] = "Password must be at least 6 characters long.";
    }
    // Confirm Password Match
    if ($password !== $confirmPassword) { // Ensure passwords match
        $errors[] = "Passwords do not match.";
    }
    // Check if Terms are Agreed To
    if (!isset($_POST['agree_terms'])) { // Ensure user agrees to terms
        $errors[] = "You must agree to the Terms of Service and Privacy Policy.";
    }
    // Check if Email or Username Already Exists
    if (checkUserExists($pdo, $email, $username)) { // Check for duplicate email or username
        $errors[] = "Email or username already exists.";
    }
    // If no errors, insert user into the database
    if (empty($errors)) { // Proceed if no validation errors
        // Hash the password for secure storage
        $hashedPassword = hashPassword($password);
        // Insert user data into the database
        try {
            $stmt = $pdo->prepare("INSERT INTO users (full_name, username, email, password_hash) VALUES (:full_name, :username, :email, :password_hash)");
            $stmt->execute([
                'full_name' => $fullName, // Bind full name
                'username' => $username, // Bind username
                'email' => $email, // Bind email
                'password_hash' => $hashedPassword // Bind hashed password
            ]);
         // Set success message in session
         $_SESSION['success'] = "Account created successfully. Welcome, $username!";
         // Redirect to the profile page
         header("Location: profile.php");
         exit;
     } catch (PDOException $e) {
         // Log database errors and set error message
         $errors[] = "Database error: Unable to create account. Please try again later.";
     }
 }
 // If there are errors, set them in the session
 if (!empty($errors)) {
     $_SESSION['error'] = implode("<br>", $errors);
 }
 // Redirect back to the auth page
 header("Location: login.php"); // CHANGED: Redirect to login.php instead of auth.php for better flow
 exit;
}
// Handle Login Form Submission
if (isset($_POST['login'])) { // Check if the login form was submitted
    // Sanitize inputs to prevent XSS attacks
    $email = htmlspecialchars(trim($_POST['email'])); // Get and sanitize email
    $password = $_POST['password']; // Get password
    // Initialize an array to store validation errors
    $errors = [];
    // Validate Email
    if (empty($email)) { // Check if email is empty
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Validate email format
        $errors[] = "Invalid email format.";
    }
    // Validate Password
    if (empty($password)) { // Check if password is empty
        $errors[] = "Password is required.";
    }
    // If no errors, authenticate the user
    if (empty($errors)) { // Proceed if no validation errors
        // Fetch user from the database by email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data as an associative array
        // Verify password
        if ($user && password_verify($password, $user['password_hash'])) { // Check if password matches
            // Store user data in session
            $_SESSION['user_id'] = $user['id']; // Store user ID
            $_SESSION['username'] = $user['username']; // Store username
            $_SESSION['email'] = $user['email']; // Store email
            // Redirect to the homepage
            header("Location: index.php");
            exit;
        } else {
            // Add error message if credentials are invalid
            $errors[] = "Invalid email or password.";
        }
    }
    // If authentication fails, set error message in session
    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
    }
    // Redirect back to the auth page
    header("Location: login.php"); // CHANGED: Redirect to login.php instead of auth.php for better flow
    exit;
}
// Default redirect if neither login nor register is set
if (!isset($_POST['register']) && !isset($_POST['login'])) {
    // Only redirect if no form submission has been detected
    header("Location: login.php"); // CHANGED: Redirect to login.php instead of auth.php for better flow
    exit;
    // Debugging: Dump session variables at the end of the script
var_dump($_SESSION); // Neil I this line here
}
?>