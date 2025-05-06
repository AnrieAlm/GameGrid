<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in to change your password.";
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'game_grid';
$user = 'root'; // adjust accordingly
$pass = ''; // adjust accordingly

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get form inputs
$currentPassword = $_POST['current-password'] ?? '';
$newPassword = $_POST['new-password'] ?? '';
$confirmPassword = $_POST['confirm-password'] ?? '';

// Validate inputs
if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: profile.php");
    exit();
}

if ($newPassword !== $confirmPassword) {
    $_SESSION['error'] = "New passwords do not match.";
    header("Location: profile.php");
    exit();
}

// Fetch current user's password hash
$stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
    $_SESSION['error'] = "Current password is incorrect.";
    header("Location: profile.php");
    exit();
}

// Hash new password
$newHash = password_hash($newPassword, PASSWORD_DEFAULT);

// Update password in database
$stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
$stmt->execute([$newHash, $_SESSION['user_id']]);

$_SESSION['success'] = "Password successfully updated.";
header("Location: profile.php");
exit();