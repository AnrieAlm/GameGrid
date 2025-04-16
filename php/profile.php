<?php
// Start the session to access session variables
session_start();
// Include the database connection file
require 'db.php';
// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}



// Fetch user details from the database based on the session user ID
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user exists in the database
if (!$user) {
    $_SESSION['error'] = "User not found.";
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GameGrid - Profile</title>
  <link rel="stylesheet" href="CSS/style2.css">
</head>

<body>
  <!-- Header Section: Logo, GameGrid Search, Menu Button -->
  <?php
// Include the header
include 'header.php';
?>

  <main>
    <!-- Profile Section -->
    <section class="profile-container" id="p_card">
      <article class="p_card">
        <!-- Profile Header with Avatar -->
        <header class="p_avatar">
          <!-- Default profile picture -->
          <img src="https://cdn-icons-png.flaticon.com/128/5663/5663802.png" 
               alt="Profile picture of <?php echo htmlspecialchars($user['username']); ?>" 
               class="profile-name">
          <!-- Display the username -->
          <h1><?php echo htmlspecialchars($user['username']); ?></h1>
        </header>

        <!-- Profile Bio -->
        <p class="p_bio">
          <?php
          // Display the user's bio if it exists; otherwise, show a default message
          echo isset($user['bio']) && !empty($user['bio'])
              ? htmlspecialchars($user['bio'])
              : "No bio available.";
          ?>
        </p>

        <!-- Edit Profile Button -->
        <article class="button-container">
          <button id="edit-profile-btn" class="btn" aria-label="Edit Profile for <?php echo htmlspecialchars($user['username']); ?>">Edit Profile</button>
        </article>
      </article>
    </section>

    <!-- Navigation Section -->
    <section class="form-container" id="p_menu-card">
      <nav>
        <ul class="p_nav list">
          <li>
            <a href="#">
              <img src="icons/dashboard_customize_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" alt="Dashboard" width="24" height="24">
              Dashboards
            </a>
          </li>
          <li>
            <a href="#">
              <img src="icons/chat_bubble_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" alt="Comments" width="24" height="24">
              Comments
            </a>
          </li>
          <li>
            <a href="#">
              <img src="icons/bookmarks_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" alt="Bookmarks" width="24" height="24">
              Bookmarks
            </a>
          </li>
          <li>
            <a href="#">
              <img src="icons/settings_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" alt="Settings" width="24" height="24">
              Settings
            </a>
          </li>
          <li>
            <a href="logout.php">
              <img src="icons/logout_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" alt="Logout" width="24" height="24">
              Logout
            </a>
          </li>
        </ul>
      </nav>
    </section>

    <!-- Bookmarks Section -->
    <section class="form-container" id="p_bookmarks-card">
      <header class="p_section-header">
        <h2 id="bookmarks-heading">Your Bookmarks</h2>
        <br>
        <hr>
        <br>
        <a href="#" class="p_view-all" aria-label="View all bookmarks">View All</a>
      </header>

      <ul class="p_bookmarks-content">
        <!-- Example bookmark list item -->
        <!-- Dynamically fetch bookmarks from the database if needed -->
        <li><a href="#">Game Review: Epic Adventure</a></li>
      </ul>
    </section>

    <!-- Account Settings Section -->
    <section class="form-container" id="profile_form" aria-labelledby="account-settings-heading">
      <h2 id="account-settings-heading">Account Settings</h2>

      <!-- Change Password Form -->
      <form class="p_password-form" action="update_password.php" method="POST">
        <fieldset>
          <legend class="sr-only">Change Password</legend>

          <!-- Current Password -->
          <label for="current-password">Current Password</label>
          <input
            type="password"
            id="current-password"
            name="current-password"
            placeholder="Enter current password"
            required
          />

          <!-- New Password -->
          <label for="new-password">New Password</label>
          <input
            type="password"
            id="new-password"
            name="new-password"
            placeholder="Enter new password"
            required
          />

          <!-- Confirm New Password -->
          <label for="confirm-password">Confirm New Password</label>
          <input
            type="password"
            id="confirm-password"
            name="confirm-password"
            placeholder="Confirm new password"
            required
          />

          <!-- Submit Button -->
          <fieldset class="form-actions" id="submit-btn">
            <button type="submit" class="btn">Save Changes</button>
          </fieldset>
        </fieldset>
      </form>
    </section>
  </main>

  <!-- Footer -->
  <?php
// Include the footer
include 'footer.php';
?>

  <!-- Add JavaScript at bottom -->
  <script src="script.js"></script>
</body>

</html>