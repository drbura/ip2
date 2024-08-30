<?php
// Database connection
$conn = new mysqli("localhost", "username", "password", "database_name");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the email is sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Query to check if the email exists in the database
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Send response back to the JavaScript
    if ($count > 0) {
        echo "exists";
    } else {
        echo "available";
    }
}

$conn->close();
?>
