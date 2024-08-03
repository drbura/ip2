<?php
$actor = $_POST['actor'] ?? '';

// Database connection
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "ddu_clerance";

// Create connection
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE request SET $actor = 'APPROVED' WHERE $actor = 'PENDING'";

if ($conn->query($sql) === TRUE) {
    echo "All requests approved successfully.";
} else {
    echo "Error updating records: " . $conn->error;
}

$conn->close();
?>
