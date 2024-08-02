<?php
session_start();
if (!isset($_SESSION['agreed'])) {
    header('Location: agree.php');
    exit;
}
// Example: Set student ID manually or through a form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $_SESSION['id'] = $_POST['id'];
}

// Make sure student_id is set in session
if (!isset($_SESSION['id'])) {
    // Redirect or handle the case where student_id is not set
    header('Location: welcome.php'); // Redirect to welcome or another page
    exit;
}

$studentId = $_SESSION['id']; // Use the student ID for displaying or processing

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ddu_clerance";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_request'])) {
    $studentId = $_POST['id'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $reason = $_POST['reason'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM ddustudentdata WHERE student_id = ?");
    $stmt->bind_param("s", $studentId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $stmt = $conn->prepare("INSERT INTO request (StudentId, AcademicYear, Semester, Reason) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $studentId, $year, $semester, $reason);
        if ($stmt->execute()) {
            $studentId = $_SESSION['student_id'];
            header('Location: status.php');
            exit;
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
            header('Location: welcome.php');
            exit;
        }
        $stmt->close();
    } else {
        $_SESSION['id_error'] = "Invalid Student ID.";
        header('Location: welcome.php');
        exit;
    }

    $conn->close();
}
?>
