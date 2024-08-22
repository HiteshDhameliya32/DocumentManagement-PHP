<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../Authentication/db_connect.php';

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'], $data['name'], $data['description'], $data['update_date'], $data['user_id'])) {
    $id = $data['id'];
    $name = $data['name'];
    $description = $data['description'];
    $update_by = $data['user_id'];
    $update_date = $data['update_date'];

    $stmt = $conn->prepare("UPDATE category SET name = ?, description = ?, update_date = ?, update_by = ? WHERE id = ?");
    $stmt->bind_param('ssssi', $name, $description, $update_date, $update_by, $id);

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
