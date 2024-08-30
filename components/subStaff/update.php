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
    // Debugging line
    var_dump($_POST); // This will print all POST data
    
    $id = $_POST['id'] ?? null;
    $table = $_POST['table'] ?? null;
    $column = $_POST['column'] ?? null;
    $value = $_POST['value'] ?? null;

   // Debugging to ensure all necessary data is received
var_dump($_POST);

// Check if data is set
if (!$id || !$table || !$column || !$value) {
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
    exit;
}

// Proceed with the update logic


    // Determine the correct table
    if ($table === 'LabAssistants-table' || $table === 'Advisors-table') {
        $sql = "UPDATE ddu_subStaff SET $column = ? WHERE subStaff_id = ?";
    }
     
    else {
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
