<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stem";  // Replace this with your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form values and trim them for extra spaces
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate that both passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;  // Stop further execution if passwords don't match
    }

    // Hash the password securely for storage
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an SQL insert statement to insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashed_password);

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        // If successful, redirect the user to index.php (home page)
        header("Location: index.html");  // Modify as needed for your actual home page
        exit();  // Ensure no further script execution happens
    } else {
        // Show an error message if the registration fails
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
