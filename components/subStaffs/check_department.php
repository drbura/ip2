<?php
// Database connection
$servername = "localhost"; // Adjust as needed
$username = "root"; // Adjust as needed
$password_db = ""; // Adjust as needed
$dbname = "ddu_clerance"; // Adjust as needed

// Create connection
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$collegeName = $_POST['collegeName'] ?? '';

$response = [];

if ($collegeName) {
    // Query to find departments with a Department Head already assigned
    $stmt = $conn->prepare("SELECT department FROM ddu_subStaff WHERE collegeName = ? AND staff = 'DepartmentHead'");
    $stmt->bind_param("s", $collegeName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all departments with assigned Department Heads
    while ($row = $result->fetch_assoc()) {
        $response[] = $row['department'];
    }

    $stmt->close();
}

$conn->close();

echo json_encode($response);
?>
