<?php
include __DIR__ . '/../Authentication/db_connect.php';

session_start(); // Start the session to access session variables

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
$response = array('success' => false, 'error' => '', 'extension' => null);

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        throw new Exception('Invalid JSON input');
    }

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    $create_by = $_SESSION['user_id'];

    if (empty($data['extension']) || empty($data['create_date'])) {
        throw new Exception('Missing required fields');
    }

    $extension = trim($data['extension']);
    $create_date = trim($data['create_date']);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO extension (extension, create_date, create_by) VALUES (?, ?, ?)");

    if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("ssi", $extension, $create_date, $create_by);

    if (!$stmt->execute()) {
        throw new Exception('Failed to add extension: ' . $stmt->error);
    }

    $response['success'] = true;
    $response['extension'] = array(
        'id' => $conn->insert_id, // Get the last inserted ID
        'extension' => $extension,
        'create_date' => $create_date,
        'create_by' => $create_by
    );

    $stmt->close();
} catch (Exception $e) {
    $response['error'] = 'Exception: ' . $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>
