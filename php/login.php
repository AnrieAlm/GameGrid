<?php

/* file that helps users to login 
Author:- Neil
*/

session_start();
//login and auth
// Redirect authenticated users to the homepage

if (isset($_SESSION['user_id'])) {

  header("Location: index.php");

  exit;

}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Authentication - Game Grid</title>
  <link rel="stylesheet" href="style2.css"> <!-- External CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
     
     .alert {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}
.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
      
  
.tab-btn {
  display: inline-block;
  padding: 10px 20px;
  margin-right: 10px;
  font-size: 16px;
  color: #ccc; /* Light gray for inactive tabs */
  text-decoration: none;
  cursor: pointer;
  position: relative;
  transition: color 0.3s ease;
}



.tab-btn.active::after {
  content: '';
  position: absolute;
  bottom: -5px;
  left: 50%;
  transform: translateX(-50%);
  width: 100%;
  height: 2px;
 
}

*/
.tab-content.active {
  display: block;
}

h2 {
  color: #00ffc8; /* Bright cyan for headings */
  font-size: 24px;
  margin-bottom: 10px;
}

p {
  font-size: 16px;
  margin-bottom: 20px;
  color: #ccc; /* Light gray for description text */
}

form label {
  display: block;
  margin-bottom: 5px;
  font-size: 14px;
  color: #ccc; /* Light gray for labels */
}

form input[type="text"],
form input[type="email"],
form input[type="password"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #333;
  border-radius: 4px;
  background-color: #282828; /* Darker input field background */
  color: white;
  font-size: 14px;
  margin: 1rem 4rem 1rem 0;
}

form input[type="text"]:focus,
form input[type="email"]:focus,
form input[type="password"]:focus {
  outline: none;
  border-color: #00ffc8; /* Highlight focused inputs with bright cyan */
}

form label > a {
  color: #00ffc8; /* Bright cyan for links */
  text-decoration: none;
}

form label > a:hover {
  text-decoration: underline;
}

.auth-submit-btn {
  display: block;
  width: 100%;
  padding: 10px;
  background-color: #00ffc8; /* Bright green for buttons */
  color: #121212; /* Dark text for contrast */
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.auth-submit-btn:hover {
  background-color: #00e6b8; /* Slightly darker green on hover */
}

.terms-note {
  font-size: 12px;
  margin-top: 10px;
  color: #777; /* Light gray for terms note */
}

/* Checkbox Styling */
input[type="checkbox"] {
  margin-right: 5px;
}

input[type="checkbox"] + label {
  font-size: 14px;
  color: #ccc; /* Light gray for checkbox label */
}
  </style>
</head>
<body>
  <?php

include 'header.php';
  // Display error or success messages if set in session
  if (isset($_SESSION['error'])) {
      echo '<div class="alert error">' . htmlspecialchars($_SESSION['error']) . '</div>';
      unset($_SESSION['error']);
  }
  if (isset($_SESSION['success'])) {
      echo '<div class="alert success">' . htmlspecialchars($_SESSION['success']) . '</div>';
      unset($_SESSION['success']);
  }

  

  ?>
       

 




  <main class="auth-container">
    <section class="auth-box">
      <nav class="auth-tabs">
        <button class="tab-btn active" data-tab="login">Login</button>
        <button class="tab-btn" data-tab="register">Register</button>
      </nav>
      <!-- Login Section -->
      <article class="tab-content" id="login-tab">
        <h1>Login to Game Grid</h1>
        <p>Access your profile and engage with the gaming community.</p>
        <form id="loginForm" method="POST" action="auth.php"><!-- neil here  -->
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
      </article>
      <!-- Register Section -->
      <article class="tab-content" id="register-tab" style="display: none;">
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
      </article>
    </section>
  </main>
  <?php include 'footer.php'; ?>
  <!-- Embedded JavaScript for Tab Switching -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const tabButtons = document.querySelectorAll('.tab-btn');
      const tabContents = document.querySelectorAll('.tab-content');

      tabButtons.forEach(button => {
        button.addEventListener('click', () => {
          const targetTab = button.getAttribute('data-tab');

          // Hide all tab contents
          tabContents.forEach(content => {
            content.style.display = 'none';
          });

          // Remove active class from all buttons
          tabButtons.forEach(btn => {
            btn.classList.remove('active');
          });

          // Show the selected tab content and mark the button as active
          document.getElementById(`${targetTab}-tab`).style.display = 'block';
          button.classList.add('active');
        });
      });
    });
  </script>
</body>
</html>