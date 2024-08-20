<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$email = $_SESSION['email'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ddu_clerance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT collegeName, department FROM ddu_subStaff WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($collegeName, $department);

$response = [];
if ($stmt->fetch()) {
    $response['collegeName'] = $collegeName;
    $response['department'] = $department;
} else {
    $response['error'] = 'No details found';
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
