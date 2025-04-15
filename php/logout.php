<?php
// Start the session to access session data
session_start();

// Destroy the session to log the user out
session_destroy();

// Redirect the user to the login page
header("Location: login.php");

// Stop further script execution
exit;
?>