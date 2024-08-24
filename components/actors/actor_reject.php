<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestId = $_POST['requestId'];
    $status = $_POST['status'];
    $actor = $_POST['actor'];
    $reason = $_POST['reason'];
    $userEmail = $_SESSION['email'];
    $date = date('Y-m-d H:i:s'); // Current timestamp

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "ddu_clerance";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the rejection reason into the 'reason' table
    $stmt = $conn->prepare("INSERT INTO reason (request_id, user_email, reason, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $requestId, $userEmail, $reason, $date);
    $stmt->execute();

    // Update the request status to 'REJECT'
    $stmt = $conn->prepare("UPDATE request SET $actor = ? WHERE RequestId = ?");
    $stmt->bind_param("i",$status, $requestId);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    echo "Request rejected successfully.";
}
?>
