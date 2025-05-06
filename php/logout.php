<?php // add class to connect 
/* file that helps in logout 
Author:- Neil*/
session_start();
session_destroy();
header("Location: login.php");
exit();
?>