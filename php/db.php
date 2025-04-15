
<?php
$host = 'localhost'; // Database host
$dbname = 'game_grid'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

try {
    // Create a new PDO instance for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable error reporting
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); // Show error if connection fails
}
?>