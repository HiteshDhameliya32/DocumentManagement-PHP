<?php
// Start the session to access session variables
session_start();

// Function to check if the user is logged in by checking if 'user_id' is set in the session
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to get the user role from the session
// Returns the role if set, otherwise returns null
function getUserRole() {
    return isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;
}

// Function to get the logged-in username from the session
// Returns the username if set, otherwise returns an empty string
function getLoggedInUsername() {
    return isset($_SESSION['username']) ? $_SESSION['username'] : '';
}

// Check if the user is not logged in
if (!isUserLoggedIn()) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    // Ensure no further output is sent after the header to avoid unexpected behavior
    exit();
}

// Get the user role from the session
$userRole = getUserRole();
// Get the username of the logged-in user from the session
$username = getLoggedInUsername();
?>
