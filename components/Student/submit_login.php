<?php
session_start();
// include 'connect.php'; // Ensure this file contains the database connection logic
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

// Fetch and sanitize input data
$studentId = mysqli_real_escape_string($conn, $_POST['ID']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check if the ID and password (both should be the same as student_id) exist in student_data table
$query = "SELECT * FROM ddustudentdata WHERE student_id = '$studentId' AND student_id = '$password'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Check if student ID exists in the request table
    $checkRequestQuery = "SELECT * FROM request WHERE StudentID = '$studentId'";
    $requestResult = $conn->query($checkRequestQuery);

    $checksRequestQuery = "SELECT * FROM clearedstudentslist WHERE student_id = '$studentId'";
    $requestsResult = $conn->query($checksRequestQuery);

    // Set session ID
    $_SESSION['id'] = $studentId;

    if ($requestsResult->num_rows > 0) {
        header("Location: final_status.php");

    }elseif ($requestResult->num_rows > 0){
        header ("Location: status.php");
    }
    else {
        header("Location: agree.php");
    }
    exit;
} else {
    // Invalid credentials
    header("Location: index.php?error=Invalid ID or Password");
    exit;
}

// Close the connection
$conn->close();
?>
