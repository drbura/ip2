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

if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    
    $stmt = $conn->prepare("SELECT COUNT(*) FROM dduStudentData WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    
    if ($count > 0) {
        echo 'exists';
    } else {
        echo 'available';
    }
    
    $stmt->close();
}

$conn->close();
?>
