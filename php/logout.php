<?php // add class to connect 
session_start();
session_destroy();
header("Location: login.php");
exit();
?>