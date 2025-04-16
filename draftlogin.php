<!--
<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Game Grid</title>
  <link href="CSS/style2.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <?php
  // Display error or success messages if set in session
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
        <li><a href="Reviews.html">Reviews</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="login.php" class="btn" id="loginBtn">Login</a></li>
      </ul>
    </nav>
  </header>

  <main class="auth-container">
    <section class="auth-box">
      <h1>Login to Game Grid</h1>
      <p>Access your profile and engage with the gaming community.</p>
      <!-- Login Form 
      <form id="loginForm" method="POST" action="auth.php">
        <input type="hidden" name="login" value="1">
        <label for="loginEmail">Email</label>
        <input type="email" id="loginEmail" name="email" placeholder="Enter your email" required>

        <label for="loginPassword">Password</label>
        <input type="password" id="loginPassword" name="password" placeholder="Enter your password" required>
        <p><a href="#" class="forgot-password">Forgot password?</a></p>

        <label>
          <input type="checkbox" id="rememberMe" name="remember_me"> Remember me
        </label>

        <button type="submit" class="auth-submit-btn" name="loginBtn">Login</button>
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

-->