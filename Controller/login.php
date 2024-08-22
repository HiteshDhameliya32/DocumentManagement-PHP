<?php
if (!isset($_SESSION)) {
    session_start();
}

include __DIR__ . '/../Authentication/db_connect.php';

if (isset($_POST['submit'])) {
    $usernameOrEmail = $_POST['username'];
    $password = $_POST['password'];

    // Validate required fields
    if (empty($usernameOrEmail) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
    } else {
        // Use prepared statement to prevent SQL injection
        $sql = "SELECT `user_id`, `password`, `username`, `user_role` FROM `as_users` WHERE `username` = ? OR `email` = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, 'ss', $usernameOrEmail, $usernameOrEmail);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Store the result
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                // Bind the result to variables
                mysqli_stmt_bind_result($stmt, $id, $hashed_password, $username, $user_role);
                mysqli_stmt_fetch($stmt);

                // Verify the password
                if (password_verify($password, $hashed_password)) {
                    // Set session variables
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['user_role'] = $user_role;

                    // Redirect based on user role
                    if ($user_role == 1) {
                        header("location: index.php");
                    } elseif ($user_role == 3) {
                        header("location: index.php");
                    } else {
                        $_SESSION['error'] = "Invalid user role.";
                        header("location: login.php");
                    }
                    exit(); // Ensure no further output after header
                } else {
                    $_SESSION['error'] = "Invalid password.";
                }
            } else {
                $_SESSION['error'] = "No user found with that username or email.";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['error'] = "Error preparing statement: " . mysqli_error($conn);
        }
    }

    // Close the database connection
    mysqli_close($conn);

    // Redirect back to the login page to show the error
    header("location: login.php");
    exit(); // Ensure no further output after header
}
?>
