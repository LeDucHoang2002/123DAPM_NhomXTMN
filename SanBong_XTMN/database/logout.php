<?php
session_start();
session_destroy(); // Destroy the session
header("Location: ..//views/log_in.php"); // Redirect to the login page
exit();
?>
