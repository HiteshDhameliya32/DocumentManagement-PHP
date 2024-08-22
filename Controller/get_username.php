<?php
include __DIR__ . '/../Authentication/db_connect.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $stmt = $conn->prepare("SELECT `username` FROM `as_users` WHERE `user_id` = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['username' => $row['username']]);
    } else {
        echo json_encode(['username' => null]);
    }

    $stmt->close();
    $conn->close();
}
else {
    echo json_encode(['error' => 'User ID not provided']);
}
?>
