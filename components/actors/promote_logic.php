<?php
session_start(); // Start session to access user data

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

// Fetch user email and check if the user is a registrar
$user_email = $_SESSION['email'] ?? '';
$role_query_staff = "SELECT 'registrar' AS role FROM ddu_staff WHERE email = ?";

$stmt = $conn->prepare($role_query_staff);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param('s', $user_email);
$stmt->execute();
$role_result = $stmt->get_result();

if ($role_result->num_rows == 0) {
    // If the user is not a registrar, stop the operation
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized action. Only registrars can promote students.']);
    exit();
}

// Fetch all students who have cleared
$sql = "SELECT student_id, Year, semester FROM ddustudentdata 
        WHERE student_id IN (SELECT student_id FROM clearedstudentslist WHERE is_completed = 1)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $student_id = $row['student_id'];
        $year = $row['Year'];
        $semester = $row['semester'];

        // Logic to promote the student based on the current semester and year
        if ($semester == 1) {
            // If it's 1st semester, promote to 2nd semester in the same year
            $new_year = $year;
            $new_semester = 2;
        } elseif ($semester == 2) {
            // If it's 2nd semester, promote to 1st semester in the next year
            $new_year = $year + 1;
            $new_semester = 1;
        }

        // Update student semester and year
        $update_sql = "UPDATE ddustudentdata SET Year = '$new_year', semester = '$new_semester' 
                       WHERE student_id = '$student_id'";

        if (!$conn->query($update_sql)) {
            echo json_encode(['status' => 'error', 'message' => 'Error updating student: ' . $conn->error]);
            exit();
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'All students promoted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No students found to promote']);
}

$conn->close();
?>
