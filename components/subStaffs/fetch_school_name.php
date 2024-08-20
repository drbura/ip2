<?php
session_start();

// Check if session email is set
if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'No session email found']);
    exit;
}

$email = $_SESSION['email'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ddu_clerance"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Query to fetch school name based on email
$sql = "SELECT schoolName FROM ddu_staff WHERE email = ?"; // Replace 'users' and 'school_name' with your actual table and column names
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($school_name);
$stmt->fetch();

$stmt->close();
$conn->close();

if ($school_name) {
    echo json_encode(['schoolName' => $school_name]);
} else {
    echo json_encode(['error' => 'School name not found']);
}
?>
