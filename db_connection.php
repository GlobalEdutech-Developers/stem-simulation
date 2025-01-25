<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stem";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
