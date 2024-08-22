<?php
header('Content-Type: application/json');

// Database connection details
$host = 'localhost';  // Update with your database host
$db   = 'replyrea_olymel';  // Update with your database name
$user = 'root';  // Update with your database username
$pass = '';  // Update with your database password

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch categories
    $stmtCategories = $pdo->query("SELECT id, name, description, create_date, update_date, create_by FROM categories");
    $categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

    // Query to fetch roles
    $stmtRoles = $pdo->query("SELECT role_id, role FROM roles");
    $roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);

    // Combine both categories and roles into one array
    $data = [
        "categories" => $categories,
        "roles" => $roles
    ];

    // Output the JSON encoded data
    echo json_encode($data);

} catch (PDOException $e) {
    // Handle connection error
    echo json_encode(["error" => $e->getMessage()]);
}
?>
