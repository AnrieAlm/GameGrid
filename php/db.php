<?php
// Database configuration
$host = 'sql103.infinityfree.com'; // Database host
$dbname = 'if0_38770055_gamegrid'; // Database name
$username = 'if0_38770055'; // Database username
$password = 'anjampattiNj9'; // Database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Set PDO error mode to exception for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    die("Database connection failed: " . $e->getMessage());
}
?>