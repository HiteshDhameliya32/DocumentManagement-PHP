<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include '../Authentication/db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // SMTP settings
    $username = "testing@replyreach.net"; // Sender email
    $password = "mR3v4wf@n"; // SMTP password
    $host = "mail.replyreach.net"; // SMTP server
    $smtp_port = 465; // SMTP port

    // Retrieve form data
    $email = htmlspecialchars($_POST['email']);

    // Prepare SQL statement
    $sql = "SELECT email FROM as_users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['error'] = 'Failed to prepare the SQL statement.';
        header('Location: ../forgot-pw.php');
        exit();
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists in the database, generate a unique token
        $token = bin2hex(random_bytes(32));

        // Update the database with the reset token
        $sql_update = "UPDATE as_users SET password_reset_key = ?, password_reset_confirmed = 0 WHERE email = ?";
        $stmt_update = $conn->prepare($sql_update);
        if ($stmt_update === false) {
            $_SESSION['error'] = 'Failed to prepare the update SQL statement.';
            header('Location: ../forgot-pw.php');
            exit();
        }
        $stmt_update->bind_param("ss", $token, $email);
        $stmt_update->execute();

        // Create the reset URL
        $reset_url = "https://olymel.replyreach.ca/test/DashHub/Controller/reset_password.php?token=" . urlencode($token);

        // Email content
        $subject = "Password Reset Request";
        $message = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Password Reset</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    color: #333;
                    line-height: 1.6;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    background: #f9f9f9;
                }
                h2 {
                    color: #333;
                }
                p {
                    font-size: 16px;
                }
                .button {
                    display: inline-block;
                    font-size: 16px;
                    color: #fff;
                    background-color: #007BFF;
                    padding: 10px 20px;
                    text-decoration: none;
                    border-radius: 5px;
                    text-align: center;
                }
                .button:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2>Password Reset</h2>
                <p>Hello,</p>
                <p>You have requested to reset your password. Please use the form below to enter a new password:</p>
                <div class="form-container">
                    <form action="' . $reset_url . '" method="post">
                        <input type="hidden" name="token" value="' . htmlspecialchars($token) . '">
                        <div class="form-group">
                            <label for="new_password">New Password:</label>
                            <input type="password" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="button">Reset Password</button>
                    </form>
                </div>
                <p>If you did not request this password reset, please ignore this email.</p>
                <p>Thank you,<br>Your Company</p>
            </div>
        </body>
        </html>';

        // Email headers
        $headers = "From: $username\r\n";
        $headers .= "Reply-To: $username\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Send the email
        if (mail($email, $subject, $message, $headers)) {
            $_SESSION['success'] = 'Password reset email sent successfully! Please check your Email';
            header('Location: ../login.php');
        } else {
            $_SESSION['error'] = 'Failed to send the password reset email. Please check the server configuration.';
        }
    } else {
        // Email does not exist in the database
        $_SESSION['error'] = 'Email not found. Please create a new account or check the email address.';
    }

    header('Location: ../forgot-pw.php'); // Redirect back to the form page
    exit();
} else {
    $_SESSION['error'] = 'Invalid request method.';
    header('Location: ../forgot-pw.php'); // Redirect back to the form page
    exit();
}
?>
