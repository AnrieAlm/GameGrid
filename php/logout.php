<?php // add class to connect 
/* file that helps in logout */
session_start();
session_destroy();
header("Location: login.php");
exit();
?>