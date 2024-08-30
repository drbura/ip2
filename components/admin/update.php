<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $table = $_POST['table'];
    $column = $_POST['column'];
    $value = $_POST['value'];

    // Determine the correct table
    if ($table === 'deans-table') {
        $sql = "UPDATE ddu_staff SET $column = ? WHERE staff_id = ?";
    } elseif ($table === 'staff-table') {
        $sql = "UPDATE ddu_staff SET $column = ? WHERE staff_id = ?";
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid table']);
        exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $value, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database update failed']);
    }

    $stmt->close();
}

$conn->close();
?>
