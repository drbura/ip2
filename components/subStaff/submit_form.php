<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "ddu_clerance";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]));
}

// Fetch and sanitize input data
$fName = mysqli_real_escape_string($conn, $_POST['fName']);
$mName = mysqli_real_escape_string($conn, $_POST['mName']);
$lName = mysqli_real_escape_string($conn, $_POST['lName']);
$collegeName = mysqli_real_escape_string($conn, $_POST['collegeName']);
$department = mysqli_real_escape_string($conn, $_POST['department']);
$year = mysqli_real_escape_string($conn, $_POST['year']);
$semester = mysqli_real_escape_string($conn, $_POST['semester']);
$role = mysqli_real_escape_string($conn, $_POST['role']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
$date = mysqli_real_escape_string($conn, $_POST['date']);

// Check if the email already exists
$emailCheckQuery = "SELECT * FROM ddu_substaff WHERE email='$email'";
$emailCheckResult = $conn->query($emailCheckQuery);

if ($emailCheckResult->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'Email already exists']);
    exit;
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO ddu_substaff (fName, mName, lName, collegeName, department, year, semester, staff, phone, email, password, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssss", $fName, $mName, $lName, $collegeName, $department, $year, $semester, $role, $phone, $email, $password, $date);

// Execute statement
if ($stmt->execute()) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    echo json_encode(['success' => false, 'error' => 'Database insert error: ' . $stmt->error]);
    exit;
}

// Close connections
$stmt->close();
$conn->close();
?>
