<?php
session_start();
include __DIR__ . '/../Authentication/db_connect.php';

// Start output buffering to prevent any accidental output
ob_start();

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Generate a user-specific directory if it doesn't exist
    $user_directory = __DIR__ . "/../uploads/$user_id/";
    if (!is_dir($user_directory)) {
        if (!mkdir($user_directory, 0777, true)) {
            $response['success'] = false;
            $response['error'] = 'Failed to create user directory.';
            echo json_encode($response);
            exit;
        }
    }

    // Create a unique filename with date, time, and user ID
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name = pathinfo($file['name'], PATHINFO_FILENAME);
    $unique_file_name = $file_name . '_' . date('Ymd_His') . "_user_$user_id.$file_extension";

    $file_path = $user_directory . $unique_file_name;

    // Move the uploaded file to the user-specific directory
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        // File moved successfully, save file details in the database
        $stmt = $conn->prepare("INSERT INTO files (name, description, file_path, create_date, create_by, category_id) VALUES (?, ?, ?, NOW(), ?, ?)");
        $stmt->bind_param("sssii", $unique_file_name, $description, $file_path, $user_id, $category_id);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['file'] = [
                'id' => $stmt->insert_id,
                'name' => $unique_file_name,
                'description' => $description,
                'file_path' => $file_path,
                'create_date' => date('Y-m-d H:i:s'),
                'create_by' => $user_id,
                'category_id' => $category_id
            ];
        } else {
            $response['success'] = false;
            $response['error'] = 'Failed to save file details in the database.';
        }

        $stmt->close();
    } else {
        $response['success'] = false;
        $response['error'] = 'Failed to move uploaded file.';
    }
} else {
    $response['success'] = false;
    $response['error'] = 'No file uploaded or invalid request.';
}

$conn->close();

// Flush (send) the output buffer and turn off output buffering
ob_end_clean();

// Set the content type to JSON and echo the response
header('Content-Type: application/json');
echo json_encode($response);
?>
