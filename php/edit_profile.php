<?php

/* file that helps in editing profile details and updates in databse too 

Author:- Anriel
*/

session_start();
require 'db.php'; // Connect to your database

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch current user data
$stmt = $pdo->prepare("SELECT full_name, username, email, bio FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);
    $password = $_POST['password'] ?? null;

    if (!$email) {
        die("Invalid email address");
    }

    // Base query
    $query = "UPDATE users SET full_name = ?, email = ?, bio = ?";
    $params = [$full_name, $email, $bio];

    // Only update password if provided
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query .= ", password_hash = ?";
        $params[] = $password_hash;
    }

    $query .= " WHERE id = ?";
    $params[] = $user_id;

    // Execute update
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    // Update session data
    $_SESSION['username'] = $user['username']; // Keep username unchanged
    
    header("Location: profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile - Game Grid</title>
    <link rel="stylesheet" href="style2.css">
</head>
<style>
    /* Unified button styling */
.btn,
.auth-submit-btn {
  display: inline-block;
  padding: 10px 20px;
  font-size: 16px;
  font-weight: 500;
  text-align: center;
  text-decoration: none;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s ease;
  background-color: #00ffc8; /* Bright green */
  color: #121212; /* Dark text for contrast */
}

.btn:hover,
.auth-submit-btn:hover {
  background-color: #00e6b8; /* Slightly darker hover state */
}

/* Special case for disabled buttons */
.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/** */
/* Expand bio field */
.bio-group {
  margin-bottom: 1.5rem;
}

.bio-textarea {
  width: 100%;
  max-width: 100%;
  min-height: 120px;
  padding: 12px 16px;
  font-size: 15px;
  line-height: 1.6;
  border-radius: 6px;
  border: 1px solid #333;
  background-color: #282828;
  color: white;
  resize: vertical;
  box-sizing: border-box;
  margin-top: 0.5rem;
}

.bio-textarea:focus {
  border-color: #00ffc8;
  outline: none;
  box-shadow: 0 0 0 3px rgba(0, 255, 200, 0.2);
}

.auth-box h2 {
    margin: 2rem;
}

    </style>
<body>
    <?php include 'header.php'; ?>
    
    <main class="auth-container">
        <section class="auth-box">
            <h2>Edit Profile</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                    <small>Username cannot be changed</small>
                </div>

                <!-- Replace with -->
<div class="form-group bio-group">
  <label for="bio">Bio</label>
  <textarea 
    id="bio" 
    name="bio" 
    rows="5" 
    class="bio-textarea"
  ><?= htmlspecialchars($user['bio']) ?></textarea>
</div>

                <div class="form-group">
                    <label>New Password (optional)</label>
                    <input type="password" name="password">
                </div>

                <button type="submit" class="auth-submit-btn">Update Profile</button>
            </form>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>