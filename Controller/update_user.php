<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../Authentication/db_connect.php';

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['user_id'], $data['email'], $data['username'], $data['user_role'])) {
    $user_id = $data['user_id'];
    $email = $data['email'];
    $username = $data['username'];
    $user_role = $data['user_role'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE as_users SET email = ?, username = ?, user_role = ? WHERE user_id = ?");
    $stmt->bind_param('ssii', $email, $username, $user_role, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

// Close the database connection
$conn->close();
?>
