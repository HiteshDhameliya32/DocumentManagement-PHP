<?php
include __DIR__ . '/../Authentication/db_connect.php';

session_start(); // Start the session to access session variables

header('Content-Type: application/json');
$response = array('success' => false, 'error' => '', 'category' => null);

try {
    $data = json_decode(file_get_contents('php://input'), true);

    // Retrieve user ID from session
    if (!isset($_SESSION['user_id'])) {
        $response['error'] = 'User not logged in';
        echo json_encode($response);
        exit;
    }
    $create_by = $_SESSION['user_id'];

    if (isset($data['name'], $data['description'], $data['create_date'], $data['update_date'])) {
        $name = trim($data['name']);
        $description = trim($data['description']);
        $create_date = trim($data['create_date']);
        $update_date = trim($data['update_date']);

        if (!empty($name) && !empty($description) && !empty($create_date) && !empty($update_date) && $create_by > 0) {
            // Prepare SQL statement
            $stmt = $conn->prepare("INSERT INTO category (name, description, create_date, update_date, create_by ,update_by) VALUES (?, ?, ?, ?, ?,?)");

            if ($stmt) {
                $stmt->bind_param("sssssi", $name, $description, $create_date, $update_date, $create_by,$create_by);
                
                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['category'] = array(
                        'id' => $stmt->insert_id,  // Get the last inserted ID
                        'name' => $name,
                        'description' => $description,
                        'create_date' => $create_date,
                        'update_date' => $update_date,
                        'create_by' => $create_by,
                        'update_by' => $create_by
                    );
                } else {
                    $response['error'] = 'Failed to add category: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $response['error'] = 'Failed to prepare statement: ' . $conn->error;
            }
        } else {
            $response['error'] = 'Invalid input data';
        }
    } else {
        $response['error'] = 'Missing required fields';
    }

} catch (Exception $e) {
    $response['error'] = 'Exception: ' . $e->getMessage();
}

$conn->close();

echo json_encode($response);
?>
