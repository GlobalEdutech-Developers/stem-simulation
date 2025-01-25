<?php
session_start();

// Enable error reporting for debugging purposes (optional, can remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // SQL query to check if user exists with the provided email
    $sql = "SELECT * FROM users WHERE email = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind parameters and execute
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User exists, verify password
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Password matches, store user info in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];

                // Redirect to index.html after successful sign-in
                header("Location: dashboard.html");
                exit(); // Terminate script after redirect to prevent further execution
            } else {
                // Incorrect password
                $_SESSION['error_message'] = 'Incorrect password';
                header("Location: index.html");
                exit();
            }
        } else {
            // No user found with the provided email
            $_SESSION['error_message'] = 'No user found with this email';
            header("Location: index.html");
            exit();
        }
    } else {
        // Database error
        echo "Database query failed: " . $mysqli->error;
        exit();
    }
} else {
    // If not a POST request, redirect back to sign-in
    header("Location: index.html");
    exit();
}

// Close the connection
$mysqli->close();
?>

