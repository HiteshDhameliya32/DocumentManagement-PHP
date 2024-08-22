<?php
header('Content-Type: application/json');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/../Authentication/db_connect.php';

// Initialize arrays to store the fetched users and roles
$users = [];
$roles = [];

// Fetch data from the as_users table
$sql_users = "SELECT user_id, email, username, user_role FROM as_users";
$result_users = $conn->query($sql_users);

if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $users[] = $row;
    }
}

// Fetch data from the as_user_roles table
$sql_roles = "SELECT role_id, role FROM as_user_roles";
$result_roles = $conn->query($sql_roles);

if ($result_roles->num_rows > 0) {
    while ($row = $result_roles->fetch_assoc()) {
        $roles[] = $row;
    }
}

// Close the database connection
$conn->close();

// Output the data as JSON
echo json_encode([
    'users' => $users,
    'roles' => $roles
]);
?>
