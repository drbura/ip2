<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fName = filter_input(INPUT_POST, 'fName', FILTER_SANITIZE_STRING);
    $mName = filter_input(INPUT_POST, 'mName', FILTER_SANITIZE_STRING);
    $lName = filter_input(INPUT_POST, 'lName', FILTER_SANITIZE_STRING);
    $collegeName = filter_input(INPUT_POST, 'collegeName', FILTER_SANITIZE_STRING);
    $department = filter_input(INPUT_POST, 'department', FILTER_SANITIZE_STRING);
    $staff = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);

    if (!$email) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email.']);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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

    $stmt = $conn->prepare("INSERT INTO ddu_subStaff (fName, mName, lName, collegeName, department, staff, phone, email, password, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $fName, $mName, $lName, $collegeName, $department, $staff, $phone, $email, $hashedPassword, $date);

    $formSubmissionSuccess = $stmt->execute();

    if ($formSubmissionSuccess) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Form submission failed.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
