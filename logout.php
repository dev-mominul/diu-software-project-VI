<?php
session_start();  // Start the session

// Destroy the session to log out the user
session_destroy();

// Redirect to login page
header("Location: login.php");
?>
