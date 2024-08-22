<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../Authentication/db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$conn) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

if (isset($data['id'])) {
    $id = $data['id'];

    $query = "SELECT `name`, `create_by` FROM `files` WHERE `id` = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Database query preparation failed']);
        exit;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $file = $result->fetch_assoc();
        $fileName = $file['name'];
        $userId = $file['create_by'];

        // Construct the URL using the user ID and filename
        $fileUrl = "https://olymel.replyreach.ca/test/DashHub/uploads/{$userId}/{$fileName}";

        // Return the URL in the JSON response
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'file_url' => $fileUrl,
            'file_name' => $fileName
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'No record found.']);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}

$conn->close();
?>
