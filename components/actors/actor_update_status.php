<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestId = $_POST['requestId'];
    $status = $_POST['status'];
    $actor = $_POST['actor'];

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

    // Update the status
    $stmt = $conn->prepare("UPDATE request SET $actor = ? WHERE RequestId = ?");
    $stmt->bind_param("si", $status, $requestId);

    
    if ($stmt->execute()) {
        echo "Status updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
