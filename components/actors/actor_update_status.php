<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestId = $_POST['requestId'];
    $status = $_POST['status'];
    $actor = $_POST['actor'];
    $current_status = $_POST['current_status'];

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

    // If status is "Reject", delete the corresponding reason
    if ($current_status === 'REJECTED') {
        $stmt_delete = $conn->prepare("DELETE FROM reason WHERE request_id = ?");
        $stmt_delete->bind_param("i", $requestId);
        if ($stmt_delete->execute()) {
            echo "Reason deleted successfully";
        } else {
            echo "Error deleting reason: " . $stmt_delete->error;
        }
        $stmt_delete->close();
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
