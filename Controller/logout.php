<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page or homepage
header("location: ../login.php");
exit(); // Ensure no further output after header
?>
