<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../Authentication/db_connect.php';

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $id = $data['id'];

    // Retrieve file details from the database
    $stmt = $conn->prepare("SELECT name, create_by FROM files WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $file = $result->fetch_assoc();
        $fileName = $file['name'];
        $userId = $file['create_by'];

        // Construct the file path
        $filePath = __DIR__ . "/../uploads/{$userId}/{$fileName}";

        // Delete the file from the server
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                // File deleted successfully, now delete the database record
                $stmt = $conn->prepare("DELETE FROM files WHERE id = ?");
                $stmt->bind_param('i', $id);

                if ($stmt->execute()) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => $stmt->error]);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to delete the file from the server']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'File not found on the server']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'File not found in the database']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

// Close the database connection
$conn->close();
?>
