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

$action = $_POST['action'];
$student_id = $_POST['student_id'];
$data = $_POST['data'];

if ($action == "update") {
    $setStatements = [];

    // Construct SQL SET clause from the received data
    foreach ($data as $column => $value) {
        $column = $conn->real_escape_string($column);
        $value = $conn->real_escape_string($value);
        $setStatements[] = "$column='$value'";
    }

    $setClause = implode(", ", $setStatements);

    // Update the student data
    $sql = "UPDATE ddustudentdata SET $setClause WHERE student_id='$student_id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating record: ' . $conn->error]);
    }

} elseif ($action == "delete") {
    // Delete the student record
    $sql = "DELETE FROM ddustudentdata WHERE student_id='$student_id'";
    $sql2 = "DELETE FROM request WHERE StudentId='$student_id'";
    $sql3 = "DELETE FROM clearedstudentslist WHERE student_id='$student_id'";
        
    if ( ($conn->query($sql) && $conn->query($sql2) && $conn->query($sql3) ) === TRUE) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting record: ' . $conn->error]);
    }
}

$conn->close();
exit();
?>
