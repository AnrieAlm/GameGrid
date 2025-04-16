<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - Game Grid</title>
  <link href="CSS/style2.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <?php
  // Display error or success messages if set in session
  if (isset($_SESSION['success'])) {
      echo '<div class="alert success">' . htmlspecialchars($_SESSION['success']) . '</div>';
      unset($_SESSION['success']);
  }
  if (isset($_SESSION['error'])) {
      echo '<div class="alert error">' . htmlspecialchars($_SESSION['error']) . '</div>';
      unset($_SESSION['error']);
  }
  ?>

  <header>
    <nav class="navbar">
      <h1 class="logo">Game Grid</h1>
      <button class="menu-toggle" aria-label="Toggle menu">☰</button>
      
      <form class="search-bar">
        <input type="text" placeholder="Search games...">
      </form>
      
      <ul class="nav-links">
        <li><a href="index.html">Home</a></li>
        <li><a href="/reviews.html">Reviews</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php" class="btn" id="registerBtn">Register</a></li>
      </ul>
    </nav>
  </header>

  <main class="auth-container">
    <section class="auth-box">
      <h2>Create Your Gaming Profile</h2>
      <p>Join thousands of gamers on Game Grid.</p>
      <form id="registerForm" method="POST" action="auth.php">
        <input type="hidden" name="register" value="1">

        <label for="fullName">Full Name</label>
        <input type="text" id="fullName" name="full_name" placeholder="Enter your full name" required>

        <label for="userName">Username</label>
        <input type="text" id="userName" name="username" placeholder="Create a username" required>

        <label for="registerEmail">Email</label>
        <input type="email" id="registerEmail" name="email" placeholder="Enter your email address" required>

        <label for="registerPassword">Password</label>
        <input type="password" id="registerPassword" name="password" placeholder="Enter your password" required>

        <label for="confirmPassword">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Re-enter your password" required>

        <label>
          <input type="checkbox" class="loginLinks" id="agreeTerms" name="agree_terms" required>
          I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
        </label>

        <button type="submit" class="auth-submit-btn" name="registerBtn">Create Account</button>

        <p class="terms-note">By registering, you agree to our Terms of Service and Privacy Policy.</p>
      </form>
    </section>
  </main>

  <footer>
    <p>© 2024 Game Grid. All rights reserved.</p>
    <a href="aboutus.html">About Us</a> 
  </footer>

  <script src="script.js"></script>
</body>

</html>