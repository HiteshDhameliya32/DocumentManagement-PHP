<?php
if (!isset($_SESSION)) {
    session_start();
}

include __DIR__ . '/../Authentication/db_connect.php';

if (isset($_POST['submit'])) {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate required fields
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $_SESSION['error'] = "Password and Confirm Password do not match.";
    } else {
        // Check if email already exists
        $sql_check_email = "SELECT * FROM `as_users` WHERE `email` = ?";
        $stmt_check_email = mysqli_prepare($conn, $sql_check_email);

        if ($stmt_check_email) {
            mysqli_stmt_bind_param($stmt_check_email, 's', $email);
            mysqli_stmt_execute($stmt_check_email);
            mysqli_stmt_store_result($stmt_check_email);

            if (mysqli_stmt_num_rows($stmt_check_email) > 0) {
                $_SESSION['error'] = "Email already exists. Please use a different email.";
            } else {
                // Generate a confirmation key
                $confirmation_key = generateConfirmationKey();
                // Generate a password reset key
                $password_reset_key = generateResetKey();

                // Current timestamp for register_date
                $register_date = date('Y-m-d H:i:s');

                // Hash the password
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);

                // Use prepared statement to prevent SQL injection
                $sql_insert_user = "INSERT INTO `as_users` (`email`, `username`, `password`, `confirmation_key`, `password_reset_key`, `register_date`) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_insert_user = mysqli_prepare($conn, $sql_insert_user);

                if ($stmt_insert_user) {
                    // Bind parameters
                    mysqli_stmt_bind_param($stmt_insert_user, 'ssssss', $email, $name, $password_hashed, $confirmation_key, $password_reset_key, $register_date);

                    // Execute the statement
                    try {
                        $result = mysqli_stmt_execute($stmt_insert_user);

                        if ($result) {
                            // Redirect to login page after successful registration
                            header("location: login.php");
                            exit();
                        } else {
                            $_SESSION['error'] = "Error executing query: " . mysqli_stmt_error($stmt_insert_user);
                        }
                    } catch (mysqli_sql_exception $e) {
                        $_SESSION['error'] = "Error: " . $e->getMessage();
                    }

                    // Close the statement
                    mysqli_stmt_close($stmt_insert_user);
                } else {
                    $_SESSION['error'] = "Error preparing statement: " . mysqli_error($conn);
                }
            }

            // Close the statement
            mysqli_stmt_close($stmt_check_email);
        } else {
            $_SESSION['error'] = "Error preparing statement: " . mysqli_error($conn);
        }
    }

    // Close the database connection
    mysqli_close($conn);

    // Redirect back to the registration page to show the error
    header("location: signin.php");
    exit();
}

// Function to generate a confirmation key (example function)
function generateConfirmationKey() {
    // Generate a unique key, for example:
    return md5(uniqid(mt_rand(), true));
}

// Function to generate a password reset key (example function)
function generateResetKey() {
    // Generate a unique reset key, for example:
    return bin2hex(random_bytes(32));
}
?>
