<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include '../Authentication/db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $token = htmlspecialchars($_POST['token']);
    $new_password = htmlspecialchars($_POST['new_password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    // Basic validation
    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match.';
        header('Location: ../login.php?token=' . urlencode($token)); // Redirect back with token
        exit();
    }

    // Prepare SQL statement to verify the token
    $sql = "SELECT user_id, email FROM as_users WHERE password_reset_key = ? AND password_reset_confirmed = 0";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $_SESSION['error'] = 'Failed to prepare the statement.';
        header('Location: ../login.php?token=' . urlencode($token)); // Redirect back with token
        exit();
    }
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the users table
        $sql = "UPDATE as_users SET password = ?, password_reset_key = NULL, password_reset_confirmed = 1 WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $_SESSION['error'] = 'Failed to prepare the update statement.';
            header('Location: ../login.php?token=' . urlencode($token)); // Redirect back with token
            exit();
        }
        $stmt->bind_param("ss", $hashed_password, $email);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Password has been reset successfully. You can now log in with your new password.';
            header('Location: ../login.php'); // Redirect to login page or similar
        } else {
            $_SESSION['error'] = 'Failed to update the password.';
            header('Location: ../login.php?token=' . urlencode($token)); // Redirect back with token
        }
    } else {
        $_SESSION['error'] = 'Invalid or expired token.';
        header('Location: ../login.php?token=' . urlencode($token)); // Redirect back with token
    }

    $stmt->close();
    exit();
} else {
    $_SESSION['error'] = 'Invalid request method.';
    header('Location: ../login.php'); // Redirect to form page
    exit();
}
?>
