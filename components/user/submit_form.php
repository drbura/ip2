<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost"; 
$username = "root"; 
$password_db = ""; 
$dbname = "ddu_clerance"; 

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array('success' => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fName = strtoupper(trim($_POST["fName"]));
    $mName = strtoupper(trim($_POST["mName"]));
    $lName = strtoupper(trim($_POST["lName"]));
    $staff = $_POST["staff"];
    $collegeName = isset($_POST["collegeName"]) ? trim($_POST["collegeName"]) : null;
    $role = trim($_POST["role"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
    $date = $_POST["date"];

    $stmt = $conn->prepare("INSERT INTO ddu_staff (fName, mName, lName, staff, schoolName, position, phone, email, password, date) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        $response['error'] = "Prepare failed: " . $conn->error;
    } else {
        $stmt->bind_param('ssssssssss', $fName, $mName, $lName, $staff, $collegeName, $role, $phone, $email, $password, $date);

        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['error'] = "Execute failed: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
echo json_encode($response);
?>
